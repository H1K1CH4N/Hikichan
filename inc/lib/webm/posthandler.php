<?php
// Glue code for handling a Tinyboard post.
// Portions of this file are derived from Tinyboard code.
function postHandler($post) {
  global $board, $config;

  if ($post->has_file) foreach ($post->files as &$file) {
      if ($file->extension == 'webm' || $file->extension == 'mp4') {
          // WebM with FFmpeg
          if ($file->extension == 'webm' && $config['webm']['use_ffmpeg']) {
              require_once dirname(__FILE__) . '/ffmpeg.php';
              $webminfo = get_webm_info($file->file_path);
              if (!isset($webminfo['error'])) {
                  $file->width = $webminfo['width'];
                  $file->height = $webminfo['height'];

                  if ($config['spoiler_images'] && isset($_POST['spoiler'])) {
                      $file = webm_set_spoiler($file);
                  } else {
                      $file = set_thumbnail_dimensions($post, $file);
                      $tn_path = $board['dir'] . $config['dir']['thumb'] . $file->file_id . '.jpg';
                      if (make_webm_thumbnail($file->file_path, $tn_path, $file->thumbwidth, $file->thumbheight, $webminfo['duration']) == 0) {
                          $file->thumb = $file->file_id . '.jpg';
                      } else {
                          $file->thumb = 'file';
                      }
                  }
              } else {
                  return $webminfo['error']['msg'];
              }
          }

          // WebM without FFmpeg
          elseif ($file->extension == 'webm') {
              require_once dirname(__FILE__) . '/videodata.php';
              $videoDetails = videoData($file->file_path);
              if (!isset($videoDetails['container']) || $videoDetails['container'] !== 'webm') {
                  return "Invalid WebM file";
              }

              if ($config['spoiler_images'] && isset($_POST['spoiler'])) {
                  $file = webm_set_spoiler($file);
              } elseif (isset($videoDetails['frame'])) {
                  $thumbName = $board['dir'] . $config['dir']['thumb'] . $file->file_id . '.webm';
                  if ($thumbFile = fopen($thumbName, 'wb')) {
                      fwrite($thumbFile, $videoDetails['frame']);
                      fclose($thumbFile);
                      $file->thumb = $file->file_id . '.webm';
                  }
              } else {
                  $file->thumb = 'file';
              }

              if (isset($videoDetails['width']) && isset($videoDetails['height'])) {
                  $file->width = $videoDetails['width'];
                  $file->height = $videoDetails['height'];
                  if ($file->thumb !== 'file' && $file->thumb !== 'spoiler') {
                      $file = set_thumbnail_dimensions($post, $file);
                  }
              }
          }

          // MP4 handling (no ffmpeg)
          elseif ($file->extension == 'mp4') {
              // Basic placeholder thumbnail
              if ($config['spoiler_images'] && isset($_POST['spoiler'])) {
                  $file = webm_set_spoiler($file);
              } else {
                  $file->thumb = 'mp4.png'; // Use a static image like "mp4.png" placed in the thumbnail folder
                  $file->thumbwidth = 100;
                  $file->thumbheight = 75;
              }

              // You could store width/height manually here if needed
              $file->width = 640;
              $file->height = 360;

              $file = set_thumbnail_dimensions($post, $file);
          }
      }
  }
}

function set_thumbnail_dimensions($post,$file) {
  global $board, $config;
  $tn_dimensions = array();
  $tn_maxw = $post->op ? $config['thumb_op_width'] : $config['thumb_width'];
  $tn_maxh = $post->op ? $config['thumb_op_height'] : $config['thumb_height'];
  if ($file->width > $tn_maxw || $file->height > $tn_maxh) {
      $file->thumbwidth = min($tn_maxw, intval(round($file->width * $tn_maxh / $file->height)));
      $file->thumbheight = min($tn_maxh, intval(round($file->height * $tn_maxw / $file->width)));
  } else {
      $file->thumbwidth = $file->width;
      $file->thumbheight = $file->height;
  }
  return $file;
}
function webm_set_spoiler($file) {
  global $board, $config;
  $file->thumb = 'spoiler';
  $size = @getimagesize($config['spoiler_image']);
  $file->thumbwidth = $size[0];
  $file->thumbheight = $size[1];
  return $file;
}