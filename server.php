<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 * XML-RPC web service entry point. The authentication is done via session tokens.
 *
 * @package    congrea xmlrpc server
 * @copyright  2021 Sumit Negi
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * NO_DEBUG_DISPLAY - disable moodle specific debug messages and any errors in output
 */
define('NO_DEBUG_DISPLAY', true);

define('WS_SERVER', true);

require('../../config.php');
require_once("$CFG->dirroot/webservice/xmlrpc/locallib.php");

if (!webservice_protocol_is_enabled('xmlrpc')) {
    debugging('The congrea xmlrpc server died because the web services or the XMLRPC protocol are not enable',
        DEBUG_DEVELOPER);
    die;
}

$server = new webservice_xmlrpc_server(WEBSERVICE_AUTHMETHOD_SESSION_TOKEN);
$server->run();
die;

/**
 * Raises Early WS Exception in XMLRPC format.
 *
 * @param  Exception $ex Raised exception.
 */
function raise_early_ws_exception(Exception $ex): void {
    global $CFG;
    require_once("$CFG->dirroot/webservice/xmlrpc/locallib.php");
    $server = new webservice_xmlrpc_server(WEBSERVICE_AUTHMETHOD_SESSION_TOKEN);
    $server->exception_handler($ex);
}
