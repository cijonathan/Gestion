<?php
class Brief_Form_AdjuntarArchivo extends Zend_Form{
	public function __construct($options = null){
		parent::__construct($options);
    }

    public function init(){
		$this->setName('archivo-adjunto');
        $this->setAttrib('id', 'form-adjuntar');
        $this->setAttrib('enctype', 'multipart/form-data');
        $this->setAttrib('class', 'form-horizontal');
        $this->setAttrib('action', "/brief/index/subir-archivo/");

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
        $fileDecorators = array(
            'File',
            // array('ViewHelper', array('helper' => 'link')), // Add ViewHelper decorator telling it to use our Link helper
            'Errors',
            // array('Description', array('tag' => 'p', 'class' => 'description')),
            array('HtmlTag',     array('class' => 'controls')),
            array( 'Label', array( 'placement' => 'prepend', 'class'=>'control-label' ) ),
            array( array( 'wrapperAll' => 'HtmlTag' ), array( 'tag' => 'div', 'class' => 'control-group' ) ),
        );

        /* ID BRIEF */
        $id_brief = $this->getAttrib('idbrief');
        $idbrief = new Zend_Form_Element_Hidden("id_brief"); 
        $idbrief
            ->removeDecorator('Label')
            ->setValue($id_brief);

        /* Nombre del archivo */
        $nombre = new Zend_Form_Element_Text('nombre');
        $nombre
            ->setLabel('Nombre:')
            ->setRequired(true)
            ->setAttrib('placeholder', 'Ingresar nombre...')
            ->setAttrib('class', 'required')
            ->setAttrib('maxlength', '255')
            ->setDecorators($decorator);
        
        /* Comentario */
        $comentario = new Zend_Form_Element_Textarea('comentario');
        $comentario
            ->setLabel('Comentario (opcional):')
            ->setAttrib('placeholder', 'Ingresar texto...')
            ->setAttrib('cols', '20')
            ->setAttrib('rows', '5')
            ->setAttrib('maxlength', '2000')
            ->setDecorators($decorator);

        /* Archivo */
        $archivo = new Zend_Form_Element_File('archivo');
        $archivo
            ->setLabel('Archivo:')
            ->setRequired(true)
            ->setMaxFileSize("5MB")
            ->addValidator('Count', false, 1)
            ->addValidator('Size', false, "5MB")
            ->setAttrib('class', 'required')
            ->setDecorators($fileDecorators);
            // ->addValidator('Extension', false, 'jpg,png,gif');

        /* Enviar elementos a la vista */
        $elementos = array($idbrief,$nombre,$comentario,$archivo);
        $this->addElements($elementos);
    }
}
?>