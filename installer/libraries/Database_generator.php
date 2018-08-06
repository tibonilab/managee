<?php

class Database_generator {

    private function _generate_array_of_queries_by_sql_file()
    {
        // Temporary variable, used to store current query
        $templine = '';
        // Read in entire file
        $lines = file(FCPATH . 'managee_db.sql');
        // init queries array
        $queries = [];

        // Loop through each line
        foreach ($lines as $line)
        {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '')
                continue;

            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';')
            {
                // accumulate query
                $queries[] = $templine;

                // Reset temp variable to empty
                $templine = '';
            }
        }

        return $queries;
    }

    public function create_db($db) 
    {
        $db->trans_begin();

        try {
            foreach($this->_generate_array_of_queries_by_sql_file() as $query) {
                $db->query($query);
            }

            $db->trans_commit();

        } catch (Exception $e) {
            $db->trans_rollback();
        }

    }

}