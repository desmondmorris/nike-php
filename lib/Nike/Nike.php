<?php

/*
 * Nike+ API class
 * API Documentation: https://developer.nike.com
 */

class Nike
{
    /**
     * Constructor
     *
     * @param array $config Configuration variables
     * @return void
     */
    public function __construct($config = array(), Request $requestInstance = null)
    {
        $this->Request = is_null( $requestInstance ) ? new Request($config) : $requestInstance;
    }

    /**
     * Sport
     * @see https://developer.nike.com/activities/get_aggregate_sport_data
     *
     * @param array $args
     * @return array
     */
    public function sport($args = array()) {
        return $this->Request->call('sport', $args);
    }

    /**
     * Activity: List
     * @see https://developer.nike.com/activities/list_users_activities
     *
     * @param array $args
     * @return array
     */
    public function activities($args = array()) {
        return $this->Request->call('activities', $args);
    }

    /**
     * Activity: Detail
     * @see https://developer.nike.com/activities/get_activity_detail_for_activity_id
     *
     * @param array $args
     * @return array
     */
    public function activities_get($args = array()) {
        if (!isset($args['activity_id'])) {
            throw new Exception("Missing activity id");
        }

        return $this->Request->call('activities/' . $args['activity_id']);
    }

    /**
     * Activity: GPS
     * @see https://developer.nike.com/activities/get_gps_data_for_activity_id
     *
     * @param array $args
     * @return array
     */
    public function activities_get_gps($args = array()) {
        if (!isset($args['activity_id'])) {
            throw new Exception("Missing activity id");
        }

        return $this->Request->call('activities/' . $args['activity_id'] . '/gps');
    }

}
