<?php
  
  function get_win_score($json, $team) {
    $data = current(json_decode($json, TRUE));
    
    // determine whether we are home or away, return the score.
    if ($data['home']['abbr'] == $team) {
      return $data['home']['score']['T'];
    }
    return $data['away']['score']['T'];
  }
  
  function get_lose_score($json, $team) {
    $data = current(json_decode($json, TRUE));
    $score = 0;
    
    foreach ($data['scrsummary'] as $key => $value) {
      if ($value['type'] == 'TD' && $value['team'] == $team) {
        $score += 7;
      }
    }
    
    return $score;
  }
  
  function get_support_score($json, $team) {
    $data = current(json_decode($json, TRUE));
    $score = 0;
    
    foreach ($data['scrsummary'] as $key => $value) {
      if ($value['team'] == $team) {
        if ($value['type'] == 'FG') {
          // field goal
          $score += 3;
          continue;
        }
        if ($value['type'] == 'TD' && !strpos($value['desc'], 'failed')) {
          // PAT successful
          $score += 1;
          continue;
        }
      }
    }
    
    return $score;
  }
