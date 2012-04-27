<?php

/**
 * BootDatePicker class file.
 * @author Sam Stenvall <sam.stenvall@arcada.fi>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets
 * @since 1.0.0
 */

/**
 * Bootstrap date picker widget.
 */
class BootDatePicker extends CWidget
{
	
	/**
	 * @var array options to pass to the picker
	 */
	public $options = array(
		'format'=>'mm/dd/yyyy',
		'weekStart'=>1,
	);

	/**
	 * @var array events that should be passed to the date picker.
	 */
	public $events = array();
	
	/**
	 * @var array the HTML attributes for the widget container.
	 */
	public $htmlOptions = array();
	
	/**
	 * Initializes the widget
	 */
	public function init()
	{
		if (!isset($this->htmlOptions['id']))
			$this->htmlOptions['id'] = $this->getId();
		
		$this->htmlOptions['type'] = 'text';
		
		// Publish and register necessary files
		$libPath = Yii::getPathOfAlias('bootstrap').'/lib/datepicker';
		
		$assetManager = Yii::app()->getAssetManager();
		$cssPath = $assetManager->publish($libPath.'/css');
		$jsPath = $assetManager->publish($libPath.'/js');
		
		$cs = Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');
		$cs->registerCssFile($cssPath.'/datepicker.css');
		$cs->registerScriptFile($jsPath.'/bootstrap-datepicker.js', CClientScript::POS_END);
	}

	/**
	 * Runs the widget 
	 */
	public function run()
	{
		$id = $this->id;
		$options = !empty($this->options) ? CJavaScript::encode($this->options) : '';
		
		ob_start();
	
		echo "jQuery('#{$id}').datepicker({$options})";
		foreach ($this->events as $event => $code)
			echo ".on('{$event}', ".CJavaScript::encode($code).")";
		
		$script = ob_get_clean();
		
		echo CHtml::tag('input', $this->htmlOptions);
		Yii::app()->getClientScript()->registerScript(__CLASS__.'#'.$id, $script);
	}

}