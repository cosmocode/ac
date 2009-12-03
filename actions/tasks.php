<?php
class syntax_plugin_activecosmo_action_tasks extends syntax_plugin_activecosmo_action {
    public function __construct($ac, $project_id, $ticket_id) {
        parent::__construct($ac);
        $this->project_id = $project_id;
        $this->ticket_id = $ticket_id;
    }

    public function exec() {
        $details = $this->ac->get('/projects/' . $this->project_id . '/tickets/' . $this->ticket_id);
        if (count($details->tasks) === 0) {
            return;
        }
        $output = '<ul>';
        foreach($details->tasks as $task) {
            if ($task->completed_on) {
                continue;
            }
            $output .= '<li><div class="li">' . $this->ac->objToString($task) . '</div></li>' . DOKU_LF;
        }
        $output .= '</ul>';

        return $output;
    }
}
