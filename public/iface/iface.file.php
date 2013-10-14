<?php
/**
 * Interface File
 * Интерфейс для сохранения файлов
 * @author Alexey iP Subbota
 * @version 1.0
 */

class iface_file
{
    public $engine = NULL;

    private $allow_imagetypes = array('image/gif', 'image/jpeg', 'image/png');


   /**
    * добавляем шаблон в список шаблонов
    * @param string fileinfo - переменная из $_FILES
    * @param string dir - директория, куда кидать
    * @param integer width - до какой ширины ресайзить
    * @param integer height - до какой высоты ресайзить
    * @param boolean crop - обрезать, если не влезает в размеры?
    * @result integer - номер записи в базе
    */
    public function saveImage($from = false, $to = false, $width = 0, $height = 0, $crop = false)
    {
        $error = array();
        if ( ($from === false) || ($to === false) )  {
            $error[] = 'no_img_path';
            return $error;
        }

        if (!($imginfo = getimagesize($from))) {
            $error[] = 'no_img_info';
            return $error;
        }

        if ( !in_array($imginfo['mime'], $this->allow_imagetypes) )  {
            $error[] = 'not_allowed_imgtype';
            return $error;
        }
        $orig = array(
            'width'  => $imginfo[0],
            'height' => $imginfo[1],
            'ratio'  => ($imginfo[0] / $imginfo[1])
        );

        $image = array(
            'width'  => ( ($width > 0)  ? $width  : $imginfo[0]),
            'height' => ( ($height > 0) ? $height : $imginfo[1])
        );
        $image['ratio'] = $image['width'] / $image['height'];

        $resample = true;
        if ( ($image['width'] >= $orig['width']) && ($image['height'] >= $orig['height']) ) {
            $resample = false;
            $image['width']  = $orig['width'];
            $image['height'] = $orig['height'];
        } else {
            if ($image['ratio'] > $orig['ratio']) {
                if ($crop == true) {
                    $orig['height'] = $orig['width'] / $image['ratio'];
                } else {
                    $image['width'] = $image['height'] * $orig['ratio'];
                }
            } else if ($image['ratio'] < $orig['ratio']) {
                if ($crop == true) {
                    $orig['width'] = $orig['height'] / $image['ratio'];
                } else {
                    $image['height'] = $image['width'] * $orig['ratio'];
                }
            }
        }

        switch ($imginfo[2]) {
            case 1: // gif
                $orig['img'] = imagecreatefromgif($from);
                break;
            case 3: // png
                $orig['img'] = imagecreatefrompng($from);
                break;
            default: // jpg
                $orig['img'] = imagecreatefromjpeg($from);
                break;
        }
        $image['img'] = imagecreatetruecolor($image['width'], $image['height']);
        imagesavealpha($image['img'], true);
        $bg_ink = imagecolorallocatealpha($image['img'], 0, 0, 0, 127);
        imagefill($image['img'], 0, 0, $bg_ink);

        if ($resample == true) {
            imagecopyresampled($image['img'], $orig['img'], 0, 0, 0, 0, $image['width'], $image['height'], $orig['width'], $orig['height']);
        } else {
            imagecopy($image['img'], $orig['img'], 0, 0, 0, 0, $orig['width'], $orig['height']);
        }
        $to = str_replace(array('.jpg', '.png', '.gif', '.jpeg'), '', $to);
        imagepng($image['img'], $to . '.png', 3);
//        $this->engine->vardump($imginfo);die();
    }

  /**
   * Сохранить файл в БД
   * @param string fileinfo - переменная из $_FILES
   * @param string dir - директория, куда кидать
   * @param string check - проверка, есть ли такой файл в базе или нет (0 - не проверять, тупо добавить новую запись и вернуть её номер, 1 - проверить и вернуть номер записи, 2 - проверить, перезаписать файл, обновить инфу в базе и вернуть вернуть номер записи)
   * @result integer - номер записи в базе
   */
  public function saveImageToBD($fileinfo, $dir, $check = false)
  {
    global $m_core;

    if ( (!isset($fileinfo['name'])) || (strlen($fileinfo['name'])==0) )  {
      return 0;
    }

    $imginfo = getimagesize($fileinfo['tmp_name']);

    if ( !in_array($imginfo['mime'], $this->allow_imagetypes) )  {
      return 0;
    }

    $query = 'SELECT id_include FROM include WHERE filepath="' . $dir . $fileinfo['name'] . '"';
    $id_include = $m_core->db->query($query, 'single');

    if ($id_include > 0) {
      if ($check == 0) {
        if ( !move_uploaded_file($fileinfo['tmp_name'], $m_core->sitepath . $dir . $fileinfo['name']) ) {
          return 0;
        }
        $query = 'INSERT INTO include SET filepath ="' . $dir . $fileinfo['name'] . '", pict_w=' . $imginfo[0] . ', pict_h=' . $imginfo[1];
        return $m_core->db->query($query);
      } else if ($check == 1) {
        return $id_include;
      } else if ($check == 2) {
        if ( !move_uploaded_file($fileinfo['tmp_name'], $m_core->sitepath . $dir . $fileinfo['name']) ) {
          return 0;
        }
        $query = 'UPDATE include SET pict_w=' . $imginfo[0] . ', pict_h=' . $imginfo[1] . ' WHERE id_include=' . $id_include;
        return $id_include;
      }
    } else {
      if ( !move_uploaded_file($fileinfo['tmp_name'], $m_core->sitepath . $dir . $fileinfo['name']) ) {
        return 0;
      }
      $query = 'INSERT INTO include SET filepath ="' . $dir . $fileinfo['name'] . '", pict_w=' . $imginfo[0] . ', pict_h=' . $imginfo[1];
      return $m_core->db->query($query);
    }
  }

  public function __construct()
  {
  }
}