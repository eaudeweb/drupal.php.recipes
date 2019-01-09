<?php

use Drupal\block_content\Entity\BlockContent;

 /**
 * Create a custom block content.
 */
function hook_update_n() {
  $block_content_type = 'basic_block';

  if (!$q = \Drupal::entityQuery('block_content_type')
      ->condition('id', $block_content_type)
      ->execute()) {
    throw new Exception('Cannot find block type <<' . $block_content_type . '>>, skipping update');
  }

  $block_content = [
    '8efda57c-55f1-45f1-88f2-596e6b3cbd36' => '<p>Lorem ipsum dolor sit amet </p><ul class="menu nav"><li><a href="#">Link #1</li><li><a href="#">Read more »</a></li></ul>',
    '06bf0ea7-5903-4741-b3d6-0aad313a12c2' => '<div class="toolbox-homepage"><a href="/page">Sample page URL</a></div>',
  ];
  foreach(['8efda57c-55f1-45f1-88f2-596e6b3cbd36' => 'Block #1', '06bf0ea7-5903-4741-b3d6-0aad313a12c2' => 'Block #2'] as $uuid => $title) {
    $uuid = '8efda57c-55f1-45f1-88f2-596e6b3cbd36';
    $content = $block_content[$uuid];
    if (!$q = \Drupal::entityQuery('block_content')
      ->condition('uuid', $uuid)
      ->execute()) {
      $this->logger()->info("Creating content block {$uuid}");
      \Drupal\block_content\Entity\BlockContent::create([
        'type' => $block_content_type,
        'info' => $title,
        'uuid' => $uuid,
        'field_title' => $title,
        'body' => [
          'value' => $content,
          'format' => 'full_html_admin'
        ],
      ])->save();
    }
  }
}
