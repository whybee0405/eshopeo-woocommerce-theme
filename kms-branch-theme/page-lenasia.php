<?php
/**
 * Template Name: Branch: Lenasia
 *
 * Applies automatically to a page with the slug "lenasia", and can also be
 * assigned by hand from the page editor.
 *
 * @package KMS_Branch
 */

defined( 'ABSPATH' ) || exit;

$GLOBALS['kms_branch_slug'] = 'lenasia';

get_header();
get_template_part( 'template-parts/branch-page', null, array( 'branch' => kms_branch( 'lenasia' ) ) );
get_footer();
