<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_ramajaxuseexample
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * HelloWorldList Model
 *
 * @since  0.0.1
 */
class RamajaxuseexampleModelBuscador extends JModelList
{

    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
                'league',
                'team',
                'player'
            );
        }

        parent::__construct($config);
    }

	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return      string  An SQL query
	 */
	protected function getListQuery()
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		// Create the base select statement.
		$query->select('*')
                ->from($db->quoteName('#__ramajax_use_example','bs'));

        // Filter: league
        $league = $this->getState('filter.league');
        if (!empty($league))
        {
            $like_league = $db->quote($league);
            $query->where('bs.league LIKE ' . $like_league);
        }

        // Filter: team
        $team = $this->getState('filter.team');
        if (!empty($team))
        {
            $like_team = $db->quote($team);
            $query->where('bs.team LIKE ' . $like_team);
        }

        // Filter: player
        $player= $this->getState('filter.player');
        if (!empty($player))
        {
            $like_player = $db->quote($player);
            $query->where('bs.player LIKE ' . $like_player);
        }

        // Filter: player_country
        $player_country= $this->getState('filter.player_country');
        if (!empty($player_country))
        {
            $like_player_country = $db->quote($player_country);
            $query->where('bs.player_country LIKE ' . $like_player_country);
        }

        // Filter: player_state
        $player_state= $this->getState('filter.player_state');
        if (!empty($player_state))
        {
            $like_player_state = $db->quote($player_state);
            $query->where('bs.player_state LIKE ' . $like_player_state);
        }

        // Filter: player_state
        $player_city= $this->getState('filter.player_city');
        if (!empty($player_city))
        {
            $like_player_city = $db->quote($player_city);
            $query->where('bs.player_city LIKE ' . $like_player_city);
        }

		return $query;
	}
}