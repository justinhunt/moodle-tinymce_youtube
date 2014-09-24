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
 * YouTube TinyMCE Editor subplugin 
 * Crowdfunded by many cool people.
 *
 * @package   tinymce_youtube
 * @copyright 2012 Justin Hunt {@link http://www.poodll.com}
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// The current plugin version (Date: YYYYMMDDXX).
$plugin->version   = 2014092400;
// Required Moodle version.
$plugin->requires  = 2012112900;
// Full name of the plugin (used for diagnostics).
$plugin->component = 'tinymce_youtube';
//beta
$plugin->maturity  = MATURITY_STABLE;
// Human readable version informatiomn
$plugin->release   = '1.0.3 (Build 2014092400)';