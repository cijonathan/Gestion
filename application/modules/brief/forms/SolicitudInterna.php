<?php
class Brief_Form_SolicitudInterna extends Zend_Form{
	public function __construct($options = null){
		parent::__construct($options);
    }

    public function init(){
		$this->setName('solicitud-interna');
        $this->setAttrib('id', 'form-solicitud');
        $this->setAttrib('class', 'form-horizontal');
        $this->setAttrib('action', "/brief/index/guardar-solicitud-interna/");

        /* Limpiar docoradores por defecto */
        $this->clearDecorators()
            ->addDecorator('FormElements')
            ->addDecorator('HtmlTag', array('tag' => 'fieldset'))
            ->addDecorator('Form');

        /* Añadir nuevos decoradores para Bootstrap Twitter */
        $decorator = array(
            'Errors',
            'ViewHelper',
            array( array( 'wrapperField' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'controls' ) ),
            array( 'Label', array( 'placement' => 'prepend', 'class'=>'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) ),
        );

         /* ID BRIEF */
        $id_brief = $this->getAttrib('idbrief');
        $idbrief = new Zend_Form_Element_Hidden("id_brief"); 
        $idbrief
            ->removeDecorator('Label')
            ->setValue($id_brief);
        
        /* Título */
        $titulo = new Zend_Form_Element_Text('titulo');
        $titulo
            ->setLabel('Título:')
            ->setRequired(true)
            ->setAttrib('placeholder', 'Ingresar título...')
            ->setAttrib('class', 'required')
            ->setAttrib('maxlength', '255')
            ->setDecorators($decorator);
        
        /* Comentario */
        $comentario = new Zend_Form_Element_Textarea('solicitud');
        $comentario
            ->setLabel('Comentario:')
            ->setAttrib('placeholder', 'Ingresar texto...')
            ->setAttrib('cols', '20')
            ->setAttrib('rows', '5')
            ->setAttrib('maxlength', '2000')
            ->setAttrib('class', 'solicitud')
            ->setRequired(true)
            ->setDecorators($decorator);

        /* Enviar elementos a la vista */
        $elementos = array($idbrief,$titulo,$comentario);
        $this->addElements($elementos);
    }
}
?>