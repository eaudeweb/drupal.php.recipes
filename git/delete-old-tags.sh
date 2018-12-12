#!/usr/bin/env bash
#
# Bash script to delete git tags older than specified number of days
# Author: Cristian Romanescu <cristian.romanescu@eaudeweb.ro>
# License: MIT
#
# Example usage to delete tags older than 9 days:
# ./delete-old-tags.sh 9

maxaged="$1"
if [ "${maxaged}" == "" ]; then
	echo "Example: Delete tags older than 9 days: ./delete-old-tags.sh 9"
	exit 1
fi

echo "Removing tags older than ${maxaged} days:"
now=$(date +%s)
for tag in $(git tag)
do
	tdh=$(git log -1 --format=%ai ${tag}) 
	td=$(git log -1 --format=%at ${tag})
	age=$(expr ${now} - ${td})
	aged=$(expr ${age} / 86400)
	if [ "${aged}" -gt  "${maxaged}" ]; then
		echo "    * Found: ${tag}"
		git tag -d "${tag}"
		if [ $? -ne 0 ]; then
			echo "Command 'git tag -d ${tag}' failed, take control ..."
			exit 1
		fi
		git push origin :refs/tags/${tag}
		if [ $? -ne 0 ]; then
			echo "Command 'git push origin :refs/tags/${tag}' failed, take control ..."
			exit 1
		fi
	fi
done
