<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Moris
 * Date: 04.08.13
 * Time: 22:19
 * To change this template use File | Settings | File Templates.
 */

class Application_Form_GuestBook_Question extends Twitter_Bootstrap_Form_Horizontal
{
    public function setParentList($parentList)
    {
        if (!empty($parentList) && $parentList != false) {
            $element = $this->getElement('parent');

            foreach ($parentList as $folder) {
                $element->addMultiOption($folder->getId(), $folder->getQuestion());
                if ($folder->hasChild()) {
                    $this->_setChildList($folder->getChild(), $element);
                }
            }
        }
    }

    protected function _setChildList($child, $element)
    {
        foreach ($child as $folder) {
            $element->addMultiOption($folder->getId(), $folder->getQuestion());
            if ($folder->hasChild()) {
                $this->_setChildList($folder->getChild(), $element);
            }
        }
    }

    public function init()
    {
        // Указываем метод формы
        $this->setMethod('post');

        $this->setIsArray(true);
        $this->setElementsBelongTo('Folder');


        $this->addElement(
            'textarea', 'question',
            array(
                 'label' => 'Вопрос',
                 'placeholder' => 'Вопрос',
                 'required' => true,
                 'validators' => array(
                     array('StringLength', true, array(0, 5000))
                 ),
                 'filters' => array('StringTrim', 'StripTags')
            )
        );

        $this->addElement(
            'select', 'parent',
            array('label' => 'Родительский элемент',
                  'required' => true
            )
        );

        $this->addElement(
            'textarea', 'answer',
            array(
                 'label' => 'Ответ',
                 'placeholder' => 'Ответ',
                 'required' => true,
                 'validators' => array(
                     array('StringLength', true, array(0, 5000))
                 ),
                 'filters' => array('StringTrim', 'StripTags')
            )
        );

        $this->addElement(
            'text', 'name',
            array(
                 'label' => 'ФИО',
                 'placeholder' => 'Фамилия Имя Отчество',
                 'required' => false,
                 'maxlength' => '255',
                 'validators' => array(
                     array('StringLength', true, array(0, 255))
                 ),
                 'filters' => array('StringTrim', 'StripTags')
            )
        );

        $this->addElement(
            'text', 'email',
            array(
                 'label' => 'E-mail',
                 'placeholder' => 'E-mail',
                 'required' => false,
                 'maxlength' => '255',
                 'validators' => array(
                     array('StringLength', true, array(0, 255))
                 ),
                 'filters' => array('StringTrim', 'StripTags')
            )
        );

        $this->addElement(
            'text', 'subject',
            array(
                 'label' => 'Тема',
                 'placeholder' => 'Тема обсуждения',
                 'required' => false,
                 'maxlength' => '255',
                 'validators' => array(
                     array('StringLength', true, array(0, 255))
                 ),
                 'filters' => array('StringTrim', 'StripTags')
            )
        );

        $this->addElement(
            'chechbox', 'moderate',
            array(
                 'label' => 'Модерация',
                 'placeholder' => 'Модерация',
                 'required' => true,
                 'validators' => array(
                     array('StringLength', true, array(0, 255))
                 ),
                 'filters' => array('StringTrim')
            )
        );


        $this->addElement(
            'button', 'submit',
            array(
                 'label' => 'Добавить',
                 'type' => 'submit',
                 'buttonType' => 'success'
            )
        );

        $this->addElement(
            'button', 'reset',
            array(
                 'label' => 'Очистить',
                 'type' => 'reset'
            )
        );

        $this->addDisplayGroup(
            array('submit', 'reset'),
            'actions',
            array(
                 'disableLoadDefaultDecorators' => true,
                 'decorators' => array('Actions')
            )
        );


    }
}