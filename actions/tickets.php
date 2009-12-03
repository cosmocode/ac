<?php
class syntax_plugin_activecosmo_action_tickets extends syntax_plugin_activecosmo_action {
    public function __construct($ac, $data) {
        parent::__construct($ac, $data);
        global $ID;
        if (is_null($data)) {
            $data = substr($ID, strpos($ID, 'projekt:') + 8);
        }
        $this->project = $data;
    }

    public function render() {
        $projects = $this->ac->get('/projects');
        $project_id = false;
        foreach($projects as $project) {
            if ($project->name === $this->project) {
                $project_id = $project->id;
                break;
            }
        }
        if ($project_id === false) {
            $output .= '<p>Project not found!</p>';
            return $output;
        }

        $tickets = $this->ac->get('/projects/' . $project_id . '/tickets');
        if (!$tickets) {
            $output .= '<p>No active tickets found!</p>';
            return $output;
        }

        $output .= '<ul>';
        foreach ($tickets as $ticket) {
            $output .= '<li><div class="li">' . $this->ac->objToString($ticket) . '</div></li>' . DOKU_LF;

            $details = $this->ac->get('/projects/' . $project_id . '/tickets/' . $ticket->ticket_id);
            if (count($details->tasks) === 0) {
                continue;
            }
            $output .= '<ul>';
            foreach($details->tasks as $task) {
                if ($task->completed_on) {
                    continue;
                }
                $output .= '<li><div class="li">' . $this->ac->objToString($task) . '</div></li>' . DOKU_LF;
            }
            $output .= '</ul>';
        }
        $output .= '</ul>';

        return $output;
    }
}
