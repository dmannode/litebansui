<?php
require_once './inc/page.php';

$page = new Page("warnings");
$page->print_title();

$page->print_page_header();

$page->print_check_form();

$page->table_begin();

$result = $page->run_query();
while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    $player_name = $page->get_name($row['uuid']);
    if ($player_name === null) continue;

    $page->print_table_rows($row, array(
        $page->lang->warns_player  => $page->get_avatar($player_name, $row['uuid']),
        $page->lang->warns_by      => $page->get_avatar($page->get_banner_name($row), $row['banned_by_uuid']),
        $page->lang->warns_reason  => $page->clean($row['reason']),
        $page->lang->warns_when    => $page->expiry($row),
        $page->lang->warns_receive => (($page->active($row, 'warned') === true) ? $page->lang->warns_yes : $page->lang->warns_no),
    ));
}
$page->table_end();
$page->print_pager();

$page->print_footer();
