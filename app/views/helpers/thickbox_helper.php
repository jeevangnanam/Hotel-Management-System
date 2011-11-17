<?php
class ThickboxHelper extends AppHelper {
    $helpers = array('Javascript', 'Html');
   
    /**
     * Set properties - DOM ID, Height and Width, Type of thickbox window - inline or ajax
     *
     * @param array $options
     */
    function setProperties($options = array())
    {
        if(!isset($options['type']))
        {
            $options['type'] = 'inline';
        }
        $this->options = $options;
    }
   
    function setPreviewContent($content)
    {
        $this->options['previewContent'] = $content;
    }
 
    function setMainContent($content)
    {
        $this->options['mainContent'] = $content;
    }
   
    function reset()
    {
        $this->options = array();
    }
   
    function output()
    {
        extract($this->options);
        if($type=='inline')
        {
            $href = '#TB_inline?';
            $href .= '&inlineId='.$id;
        }
        elseif($type=='ajax')
        {
            $ajaxUrl = $this->Html->url($ajaxUrl);
            $href = $ajaxUrl.'?';
        }
               
        if(isset($height))
        {
            $href .= '&height='.$height;
        }
        if(isset($width))
        {
            $href .= '&width='.$width;
        }
       
       
        $output = '<a class="thickbox" href="'.$href.'">'.$previewContent.'</a>';
       
        if($type=='inline')
        {
            $output .= '<div id="'.$id.'" style="display:none;">'.$mainContent.'</div>';
        }
       
        unset($this->options);
       
        return $output;
    }
   
    function beforeRender()
    {
        $out = $this->Html->css('/effects/css/thickbox.css').'<script src="'.$this->Html->url('/effects/js/thickbox-compressed.js').'"></script>';
        $view =& ClassRegistry::getObject('view');
        $view->addScript($out);
    }
 
}
?>