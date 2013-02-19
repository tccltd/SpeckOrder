<?php

namespace SpeckOrder\Form;

use Zend\Form\Form as ZendForm;
use Zend\Form\FieldSet;
use Zend\Form\Element;

class OrderSearch extends ZendForm
{
    public function __construct()
    {
        parent::__construct();

        $text = new FieldSet('text');
        $text->add(array(
            'name' => 'order_number',
            'type' => '\Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Order #',
            ),
            'attributes' => array(
                'class' => 'span12'
            ),
        ));
        $text->add(array(
            'name' => 'ref_num',
            'type' => '\Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Reference #',
            ),
            'attributes' => array(
                'class' => 'span12'
            ),
        ));
        $text->add(array(
            'name' => 'status',
            'type' => '\Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Status',
            ),
            'attributes' => array(
                'class' => 'span12'
            ),
        ));
        $text->add(array(
            'name' => 'created_time[start]',
            'type' => '\Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Created: Start',
            ),
            'attributes' => array(
                'class' => 'span12 datepicker',
            ),
        ));
        $text->add(array(
            'name' => 'created_time[end]',
            'type' => '\Zend\Form\Element\Text',
            'options' => array(
                'label' => 'Created: End',
            ),
            'attributes' => array(
                'class' => 'span12 datepicker',
            ),
        ));


        $this->add($text);

        $this->add(new FieldSet('filters'));

        $buttons = new FieldSet('buttons');
        $buttons->add(array(
            'name' => 'submit',
            'type' => '\Zend\Form\Element\Submit',
            'attributes' => array(
                'value' => 'Search',
                'class' => 'span12',
            ),
        ));
        $this->add($buttons);
    }

    public function setFilters(array $filters)
    {
        foreach ($filters as $flagId => $label) {
            $name  = 'filters[' . $flagId . ']';
            $radio = new Element\Radio($name);
            $radio->setLabel($label);
            $radio->setValueOptions(
                array('ignore' => 'ignore','show' => 'show', 'hide' => 'hide')
            );
            $this->get('filters')->add($radio);
        }
    }
}
