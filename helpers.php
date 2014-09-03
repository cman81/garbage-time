<?php
  function get_primary_score ($json, $team) {
    // this team won, return the score
    if ($data['home']['abbr'] == $team) {
      if ($data['home']['score']['T'] > $data['away']['score']['T']) {
        return $data['home']['score']['T'];
      }
    } else {
      if ($data['away']['score']['T'] > $data['home']['score']['T']) {
        return $data['away']['score']['T'];
      }
    }
    
    // this team tied or lost, only score 7/pts per touchdown
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
