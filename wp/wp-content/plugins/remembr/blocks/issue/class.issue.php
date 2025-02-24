<?php

class Remembr_Issue {

  public bool $is_user_connected;
  public int $user_id;
  
  public bool $is_post;
  public WP_Post $post;
  public array $blocks;
  public array $remember_issue_blocks;

  public function __construct() {
    $this->user_id = get_current_user_id();
    $this->is_user_connected = $this->user_id > 0;

    $this->post = get_post();
    $this->is_post = isset($this->post);
    if ($this->is_post) {
      $this->blocks = parse_blocks($this->post->post_content);
      $this->remember_issue_blocks = array_filter($this->blocks, function($obj) {
        return $obj['blockName'] == 'remembr/issue';
      });
    }
  }
  
	public function get_is_last_issue_block (&$attributes) {
    if ($this->is_post) {
      $last_block_index = array_search('remembr/issue', array_reverse(array_column($this->blocks, 'blockName'), true));
      $last_block = $this->blocks[$last_block_index];
      return $last_block['attrs']['question'] == $attributes['question'] && $last_block['attrs']['response'] == $attributes['response'];
    }
    return false;
  }

  public function get_is_learning () {
    require_once REMEMBR__PLUGIN_DIR . 'class.remembr-data.php';
    return Remembr_Data::get_is_learning($this->user_id, $this->post->ID);
  }

  public function get_learning_progress () {
    require_once REMEMBR__PLUGIN_DIR . 'class.remembr-data.php';
    return Remembr_Data::get_learning_progress_by_post($this->user_id, $this->post->ID);
  }

  public function get_is_user_submitting () {
    return isset($_POST['done']) && isset($_POST['postID']);
  }

  public function user_submit () {
    require_once REMEMBR__PLUGIN_DIR . 'class.remembr-data.php';
    $db_questions = Remembr_Data::get_questions($this->post->ID);

    foreach ($this->remember_issue_blocks as $issue_block) {
      $question = $issue_block['attrs']['question'];
      $response = $issue_block['attrs']['response'];

      // 1. search questions in DB
      // 2. add questions in DB table (or get questions ID)
      $question_id = -1;
      if (isset($db_questions)) {
        foreach($db_questions as $key => $value) {
          if ($value->question == $question && $value->response == $response) {
            $question_id = $value->id;
          }
        }

        if ($question_id < 0) {
          $question_id = Remembr_Data::add_questions($this->user_id, $question, $response);
        }
      }
      
      // 3. add user spaced repetition to DB table
      Remembr_Data::add_spaced_repetition($this->user_id, $question_id);
    }

    return count($this->remember_issue_blocks);
  }
}
