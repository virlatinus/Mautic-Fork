<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */
$view->extend('MauticCoreBundle:Default:content.html.php');
$view['slots']->set('headerTitle', $view['translator']->trans('mautic.campaign.campaigns'));

$pageButtons = [];
if ($permissions['campaign:campaigns:create']) {
    $pageButtons[] = [
        'attr' => [
            'data-toggle' => 'ajaxmodal',
            'data-target' => '#MauticSharedModal',
            'data-header' => $view['translator']->trans('mautic.campaign.import_caption'),
            'href'        => $view['router']->path('mautic_campaign_action', ['objectAction' => 'import']),
        ],
        'iconClass' => 'fa fa-upload',
        'btnText'   => 'mautic.lead.lead.import',
    ];
}

$view['slots']->set(
    'actions',
    $view->render(
        'MauticCoreBundle:Helper:page_actions.html.php',
        [
            'templateButtons' => [
                'new' => $permissions['campaign:campaigns:create'],
            ],
            'customButtons' => $pageButtons,
            'routeBase'     => 'campaign',
        ]
    )
);
?>

<div class="panel panel-default bdr-t-wdh-0">
	<?php echo $view->render('MauticCoreBundle:Helper:list_toolbar.html.php', [
        'searchValue' => $searchValue,
        'searchHelp'  => 'mautic.core.help.searchcommands',
        'action'      => $currentRoute,
        'filters'     => $filters,
    ]); ?>

    <div class="page-list">
        <?php $view['slots']->output('_content'); ?>
    </div>
</div>