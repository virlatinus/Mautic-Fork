<?php

/*
 * @copyright   2015 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Mautic\CampaignBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ImportType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('json', 'textarea', [
            'label'      => 'mautic.campaign.import_description',
            'label_attr' => ['class' => 'control-label'],
            'attr'       => ['class' => 'form-control', 'rows' => 10],
            'required'   => false,
        ]);

        $builder->add(
            'buttons',
            'form_buttons',
            [
                'apply_text'     => false,
                'save_text'      => 'mautic.lead.lead.import',
                'save_icon'      => 'fa fa-upload',
                'cancel_onclick' => 'javascript:void(0);',
                'cancel_attr'    => [
                    'data-dismiss' => 'modal',
                ],
            ]
        );

        $builder->add(
            'notify',
            'yesno_button_group',
            [
                'label'      => 'mautic.campaign.import_notify',
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class' => 'form-control',
                ],
                'data'     => true,
                'required' => false,
            ]
        );

        if (!empty($options['action'])) {
            $builder->setAction($options['action']);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'campaign_import';
    }
}
