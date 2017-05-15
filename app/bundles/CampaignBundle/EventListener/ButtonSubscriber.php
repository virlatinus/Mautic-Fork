<?php

/*
 * @copyright   2016 Mautic Contributors. All rights reserved
 * @author      Mautic, Inc.
 *
 * @link        https://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\CampaignBundle\EventListener;

use Mautic\CoreBundle\CoreEvents;
use Mautic\CoreBundle\Event\CustomButtonEvent;
use Mautic\CoreBundle\EventListener\CommonSubscriber;
use Mautic\CoreBundle\Templating\Helper\ButtonHelper;
use Mautic\PluginBundle\Helper\IntegrationHelper;

class ButtonSubscriber extends CommonSubscriber
{
    /**
     * @var IntegrationHelper
     */
    protected $helper;

    /**
     * ButtonSubscriber constructor.
     *
     * @param IntegrationHelper $helper
     */
    public function __construct(IntegrationHelper $helper)
    {
        parent::__construct();

        $this->helper = $helper;
    }

    public static function getSubscribedEvents()
    {
        return [
            CoreEvents::VIEW_INJECT_CUSTOM_BUTTONS => ['injectViewButtons', 0],
        ];
    }

    /**
     * @param CustomButtonEvent $event
     *
     * @throws \Symfony\Component\Routing\Exception\InvalidParameterException
     * @throws \Symfony\Component\Routing\Exception\MissingMandatoryParametersException
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     * @throws \InvalidArgumentException
     */
    public function injectViewButtons(CustomButtonEvent $event)
    {
        if (0 === strpos($event->getRoute(), 'mautic_campaign_')) {
            $event->addButton(
                [
                    'attr' => [
                        'class'       => 'btn btn-default btn-sm btn-nospin',
                        'data-toggle' => 'ajaxmodal',
                        'data-target' => '#MauticSharedModal',
                        'onclick'     => 'this.href=\''.
                            $this->router->generate(
                                'mautic_campaign_action',
                                ['objectAction' => 'export']
                            ).
                            '?\' + mQuery.param({\'campaigns\':{\'ids\':JSON.parse(Mautic.getCheckedListIds(false, true))}});return true;',
                        'data-header' => $this->translator->trans('mautic.campaign.export_button'),
                    ],
                    'btnText'   => $this->translator->trans('mautic.campaign.export_button'),
                    'iconClass' => 'fa fa-download',
                ],
                ButtonHelper::LOCATION_BULK_ACTIONS
            );

            if ($event->getItem()) {
                $importButton = [
                    'attr' => [
                        'data-toggle' => 'ajaxmodal',
                        'data-target' => '#MauticSharedModal',
                        'data-header' => $this->translator->trans('mautic.campaign.export_caption'),
                        'href'        => $this->router->generate(
                            'mautic_campaign_action',
                            ['objectId' => $event->getItem()->getId(), 'objectAction' => 'export']
                        ),
                    ],
                    'btnText'   => $this->translator->trans('mautic.campaign.export'),
                    'iconClass' => 'fa fa-download',
                ];

                $event
                    ->addButton(
                        $importButton,
                        ButtonHelper::LOCATION_PAGE_ACTIONS,
                        ['mautic_campaign_action', ['objectAction' => 'view']]
                    )
                    ->addButton(
                        $importButton,
                        ButtonHelper::LOCATION_LIST_ACTIONS,
                        'mautic_campaign_index'
                    );
            }
        }
    }
}
