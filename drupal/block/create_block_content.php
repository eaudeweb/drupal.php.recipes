<?php

 use Drupal\block_content\Entity\BlockContent;
 
 /**
 * Create a custom block content.
 */
function hook_update_n() {
  BlockContent::create([
    'type' => 'highlight',
    'info' => 'CBM Highlight',
    'uuid' => 'b8ce6c6b-06c0-4a2c-b365-c8a4128c603a',
    'field_title' => 'UNCCD - CBM PHOTO COMPETITION 2018:',
    'body' => 'Stories of Global Land Degradation',
    'field_link' => [
      'uri' => 'internal:#',
      'title' => 'Read More',
    ]
  ])->save();
}
