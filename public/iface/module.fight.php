<?php
/**
 * Module Fight
 * Модуль, отвечающий за бои
 * @author Alexey iP Subbota
 * @version 1.0
 */
class module_fight
{
    private $delta_size = 4;
    private $hairs_count = 24;
    private $eyes_count = 20;
    private $mouth_count = 19;

    public function &getFighters(array $param)
    {
        $result = false;

        if ( !isset($param['user_size']) || ($param['user_size'] <= 0) ) {
            return $result;
        }

        if ( !isset($param['limit']) || ($param['limit'] <= 0) ) {
            return $result;
        }

        if ( !isset($param['user_id']) || ($param['user_id'] <= 0) ) {
            return $result;
        }

        $result = array();
        $fighters = array();

        if ($param['user_size'] > 10) {
            if ($param['special'] == 0) {
                if (mt_rand(0,250) > 248) {
                    $pers_size = $user_size + mt_rand(5, 20);
                    $result[] = array(
                        'user_id'        => 0,
                        'display_name'   => 'Чёрный Властелин',
                        'hair_pos'       => 0,
                        'eyes_pos'       => 0,
                        'mouth_pos'      => 0,
                        'pers_color'     => '#5c2a22',
                        'pers_size'      => $pers_size,
                        'pers_height'    => ceil($pers_size/2),
                        'pers_special'   => 1,
                        'last_fight_bot' => '0000-00-00 00:00:00'
                    );
                    $limit--;

                } else if (mt_rand(0,250) > 248) {
                    $pers_size = $user_size - mt_rand(5, 15);
                    $result[] = array(
                        'user_id'        => 0,
                        'display_name'   => 'Добрая Фея',
                        'hair_pos'       => 212,
                        'eyes_pos'       => 0,
                        'mouth_pos'      => 0,
                        'pers_color'     => '#f7bf9f',
                        'pers_size'      => $pers_size,
                        'pers_height'    => ceil($pers_size/2),
                        'pers_special'   => 2,
                        'last_fight_bot' => '0000-00-00 00:00:00'
                    );
                    $limit--;
                }
            }

            $getparam = array();
            if (isset($param['id_not'])) {
            $getparam['id_not'] = $param['id_not'];
            $getparam['user_type'] = array(1, 2, 10);

            if ($take_friends == 0) {
                $last_fight_bot_query = ' AND last_fight_bot<="' . $last_fight_bot . '"';
                $types_query = '';
            }
            

            $query = 'SELECT id, display_name, size, style, last_fight_bot FROM user WHERE size BETWEEN ' . ($user_size - $this->delta_size) . ' AND ' . ($user_size + $this->delta_size) . $last_fight_bot_query .  ' AND id<>' . $user_id . $no_get_str . $types_query;
            $fighters = module_core::$db->query($query);
        }

        $f_count = count($fighters) + 1;

        while ($limit > 0) {
          $f_id = ($take_friends == 1) ? ($limit - 1) : mt_rand(0, $f_count);
          if ( ($f_count > 0) && (isset($fighters[$f_id])) ) {
            $style = explode(',', $fighters[$f_id]['style']);
            $result[] = array(
              'user_id'        => intval($fighters[$f_id]['id']),
              'display_name'   => $fighters[$f_id]['display_name'],
              'hair_pos'       => $style[0]*(140),
              'eyes_pos'       => $style[1]*(86),
              'mouth_pos'      => $style[2]*(86),
              'pers_color'     => $style[3],
              'pers_size'      => intval($fighters[$f_id]['size']),
              'pers_height'    => ceil($fighters[$f_id]['size']/2),
              'pers_special'   => 0,
              'last_fight_bot' => $fighters[$f_id]['last_fight_bot']
            );
            unset($fighters[$f_id]);
          } else if ($take_friends == 0) {
            if ($user_size < 5) {
              $pers_size = mt_rand(1, 2);
            } else if ($user_size < 10) {
              $pers_size = mt_rand(1, 10);
            } else {
              $low_size = $user_size - $this->delta_size;
              $max_size = $user_size + $this->delta_size;

              if ($user_size < 60) {
                if ($take_side == 2) {
                  $low_size -= 3;
                } else {
                  $max_size += 2;
                }
              } else if ($user_size < 160) {
                if ($take_side == 2) {
                  $low_size -= 2;
                } else {
                  $max_size += 1;
                }
              }

              $pers_size = mt_rand($low_size, $max_size);
            }

            $p_color = array();
            for ($i=0; $i<3; $i++) {
              $p_color[$i] = dechex(mt_rand(20, 255));
            }

            $result[] = array(
              'user_id'        => 0,
              'display_name'   => 'Пепяко-монстер',
              'hair_pos'       => mt_rand(0, $this->hairs_count)*(140),
              'eyes_pos'       => mt_rand(0, $this->eyes_count)*(86),
              'mouth_pos'      => mt_rand(0, $this->mouth_count)*(86),
              'pers_color'     => '#' . $p_color[0] . $p_color[1] . $p_color[2] ,
              'pers_size'      => $pers_size,
              'pers_height'    => ceil($pers_size/2),
              'pers_special'   => 0,
              'last_fight_bot' => '0000-00-00 00:00:00'
            );
          }
          $limit--;
        }

        return $result;
    }

    public function &doFight($user_id, array $side1 = null, array $side2 = null)
    {
      $sides = array(0=>$side1, 1=>$side2);
      $sides_query_id = array(0=>array(), 1=>array());
      $sides_length = array(0=>0, 1=>0);

      for ($i=0; $i<2; $i++) {
        foreach ($sides[$i] AS $key=>&$pers) {
          $sides_length[$i] += $pers['pers_size'];
          if ($pers['user_id']>0) {
            $sides_query_id[$i][] = $pers['user_id'];
          }
        }
      }

      $user_length_delta = 0;
      $win_side = 0;
      $lose_side = 0;

      if ($sides_length[0] > $sides_length[1]) {
        $win_side = 1;
        $lose_side = 2;
      } else if ($sides_length[1] > $sides_length[0]) {
        $win_side = 2;
        $lose_side = 1;
      }

      $time_of_fight = date('Y-m-d H:i:s');

      if ($win_side>0) {
        $sides_length_delta = abs($sides_length[1]-$sides_length[0]);

        $query = 'SELECT MAX(size) FROM user WHERE user_type > 1';
        $max_size = module_core::$db->query($query, 'single');
        $plu_perc = 1 / $max_size;

        if (count($sides_query_id[$win_side-1]) > 0) {
          $query = 'SELECT id, wins, size FROM user WHERE id IN (' . implode(',', $sides_query_id[$win_side-1]) . ')';
          $winners = module_core::$db->query($query, 'list');
          foreach ($winners AS $key=>&$winner) {
            $fight_bot_time = '';
            if ($winner['id'] != $user_id) {
              $length_delta = ceil($sides_length_delta * (1.1 - $plu_perc*$winner['size']) * 0.5);
              $fight_bot_time = ', last_fight_bot="' . $time_of_fight . '"';
            } else {
              $length_delta = ceil($sides_length_delta * (1.1 - $plu_perc*$winner['size']));
              $user_length_delta = $length_delta;
            }
            $winner['size'] = $winner['size'] + $length_delta;

            $query = 'UPDATE user SET wins=' . ($winner['wins']+1) . ', size=' . $winner['size'] . $fight_bot_time . ' WHERE id = ' . $winner['id'];
            module_core::$db->query($query);
          }
        }

        if (count($sides_query_id[$lose_side-1]) > 0) {
          $query = 'SELECT id, loses, size FROM user WHERE id IN (' . implode(',', $sides_query_id[$lose_side-1]) . ')';
          $losers = module_core::$db->query($query, 'list');
          foreach ($losers AS $key=>&$loser) {
            $fight_bot_time = '';
            $length_delta = ceil( ($sides_length_delta * (1.1 - $plu_perc*$loser['size'])) * 0.5 );
            $loser['size'] = $loser['size'] - $length_delta;

            if ($loser['size'] < 2) {
              $length_delta = $length_delta + $loser['size'] - 2;
              $loser['size'] = 2;
            }
            if ($loser['id'] != $user_id) {
              $fight_bot_time = ', last_fight_bot="' . $time_of_fight . '"';
            } else {
              $user_length_delta = (-1)*$length_delta;
            }
            $query = 'UPDATE user SET loses=' . ($loser['loses']+1) . ', size=' . $loser['size'] . $fight_bot_time . ' WHERE id = ' . $loser['id'];
            module_core::$db->query($query);
          }
        }
      }

      $result = array(
        'win_side'          => $win_side,
        'lose_side'         => $lose_side,
        'user_length_delta' => $user_length_delta,
        'time_of_fight'     => $time_of_fight
      );

      return $result;
    }


    public function checkAchievs(array &$user_info = null, array &$side1 = null, array &$side2 = null, array &$fight_result = null)
    {
      $has_achievs = array();
      $achiev_query = 'INSERT INTO achievs_user SET id_user = ' . $user_info['id'] . ', date_create = "' . $fight_result['time_of_fight'] . '", ';

      $query = 'SELECT id_achiev FROM achievs_user WHERE id_user = ' . $user_info['id'];
      $has_achievs = module_core::$db->query($query, 'array', 'id_achiev');
      if ($has_achievs !== false) {
        $has_achievs = array_flip($has_achievs);
      }

      $win = false;
      if ($fight_result['win_side']==1) {
        $win = true;
        if (!isset($has_achievs[1])) {
          $query = $achiev_query . 'id_achiev = 1';
          module_core::$db->query($query);
        }

        if ( !isset($has_achievs[2]) && ($user_info['wins']>=50) ) {
          $query = $achiev_query . 'id_achiev = 2';
          module_core::$db->query($query);
        }
        if ( !isset($has_achievs[3]) && ($user_info['wins']>=150) ) {
          $query = $achiev_query . 'id_achiev = 3';
          module_core::$db->query($query);
        }
        if ( !isset($has_achievs[11]) && ($user_info['wins']>=350) ) {
          $query = $achiev_query . 'id_achiev = 11';
          module_core::$db->query($query);
        }
      }

      if ( !isset($has_achievs[6]) && ($user_info['size']>=100) ) {
        $query = $achiev_query . 'id_achiev = 6';
        module_core::$db->query($query);
      }

      if ( !isset($has_achievs[7]) && ($user_info['size']>=250) ) {
        $query = $achiev_query . 'id_achiev = 7';
        module_core::$db->query($query);
      }

      if ( !isset($has_achievs[8]) && ($user_info['size']<10) ) {
        $query = $achiev_query . 'id_achiev = 8';
        module_core::$db->query($query);
      }

      foreach ($side2 AS $s_key=>$side) {
        if ($side['pers_special']==1) {
          if (!isset($has_achievs[4])) {
            $query = $achiev_query . 'id_achiev = 4';
            module_core::$db->query($query);
          }
          if ( !isset($has_achievs[9]) && ($win == true) ) {
            $query = $achiev_query . 'id_achiev = 9';
            module_core::$db->query($query);
          }
          break;
        } else if ($side['pers_special']==2) {
          if (!isset($has_achievs[5])) {
            $query = $achiev_query . 'id_achiev = 5';
            module_core::$db->query($query);
          }
          if ( !isset($has_achievs[10]) && ($win == false) ) {
            $query = $achiev_query . 'id_achiev = 10';
            module_core::$db->query($query);
          }
          break;
        }
      }

      if ( !isset($has_achievs[12]) && ($user_info['fights_win']>=5) ) {
        $query = $achiev_query . 'id_achiev = 12';
        module_core::$db->query($query);
      }

      if ( !isset($has_achievs[13]) && ($user_info['fights_win']>=10) ) {
        $query = $achiev_query . 'id_achiev = 13';
        module_core::$db->query($query);
      }

      if ( !isset($has_achievs[14]) && ($user_info['fights_win']>=15) ) {
        $query = $achiev_query . 'id_achiev = 14';
        module_core::$db->query($query);
      }
    }

    /**
     * Конструктор
     */
    public function __construct()
    {
    }
}