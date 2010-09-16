<?php
class syntax_plugin_ac_action_tickets extends syntax_plugin_ac_action {
    public function __construct($ac, $data) {
        parent::__construct($ac);
        global $ID;
        if (is_null($data[0])) {
            $data[0] = substr($ID, strpos($ID, 'projekt:') + 8);
        }
        $this->project = $data[0];
    }

    public function exec() {
        $projectid = 0;
        if ((int) $this->project !== 0) {
            $projectid = $this->project;
        } else {
            $project = $this->ac->fetchSingle('projects', array('name' => $this->project));
            if ($project === false) {
                return '<p>Project not found!</p>';
            }
            $projectid = $project->id;
        }

        $tickets = $this->ac->get('projects/' . $projectid . '/tickets');
        if (!$tickets) {
            return '<p>No active tickets found!</p>';
        }

        $output = '<ul>';
        foreach ($tickets as $ticket) {
            $output .= '<li><div class="li">' . $this->ac->objToString($ticket) . '</div>' .
                       ajax_loader::getLoader('ac', array('tasks', $projectid, $ticket->ticket_id)) . '</li>' . DOKU_LF;
        }
        $output .= '</ul>';

        return $output;
    }
}
