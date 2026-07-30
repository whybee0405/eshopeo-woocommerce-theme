<?php
/**
 * Template Name: Branch: Vereeniging
 *
 * Applies automatically to a page with the slug "vereeniging", and can also be
 * assigned by hand from the page editor.
 *
 * @package KMS_Branch
 */

defined( 'ABSPATH' ) || exit;

$GLOBALS['kms_branch_slug'] = 'vereeniging';

get_header();
get_template_part( 'template-parts/branch-page', null, array( 'branch' => kms_branch( 'vereeniging' ) ) );
get_footer();
