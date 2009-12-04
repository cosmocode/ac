<?php
class syntax_plugin_activecosmo_action_tickets extends syntax_plugin_activecosmo_action {
    public function __construct($ac, $data) {
        parent::__construct($ac);
        global $ID;
        if (is_null($data)) {
            $data = substr($ID, strpos($ID, 'projekt:') + 8);
        }
        $this->project = $data;
    }

    public function exec() {
        $projects = $this->ac->get('/projects');
        $project_id = false;
        foreach($projects as $project) {
            if ($project->name === $this->project) {
                $project_id = $project->id;
                break;
            }
        }
        if ($project_id === false) {
            return '<p>Project not found!</p>';
        }

        $tickets = $this->ac->get('/projects/' . $project_id . '/tickets');
        if (!$tickets) {
            return '<p>No active tickets found!</p>';
        }

        $output = '<ul>';
        foreach ($tickets as $ticket) {
            $tasks = new syntax_plugin_activecosmo_action_tasks($this->ac, $project_id, $ticket->ticket_id);
            $output .= '<li><div class="li">' . $this->ac->objToString($ticket) . '</div>' .
                       ajax_loader::getLoader('activecosmo', $tasks) . '</li>' . DOKU_LF;
        }
        $output .= '</ul>';

        return $output;
    }
}
