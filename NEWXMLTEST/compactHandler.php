<?php
class CompactHandler {
	var $closed, $indent, $chars;

      function CompactHandler(){
            $this->closed=false;
            $this->indent=0;
            $this->chars="";
        }

	function startElement($parser, $localname, array $attributes){
            $this->flushChars();
            if ($this->closed) {
				print "\n".str_repeat(' ',$this->indent);
				               $this->closed=false;
            }
            $this->indent+=1+strlen($localname);
            print $localname."[";
            $first=true;
            foreach ($attributes as $attrName => $attrValue){
                if(!$first)print "\n".str_repeat(' ',$this->indent);
                print "@".$attrName."[".$attrValue."]";
                $first=false;
                $this->closed=true;
            }
        }

	function endElement($parser, $localname){
            $this->flushChars();
            print "]";
            $this->closed=true;
            $this->indent-=1+strlen($localname);
        }

       function characters($parser, $text){
            if(strlen(trim($text))>0){
				if ($this->closed) {
					print "\n".str_repeat(' ',$this->indent);
					$this->closed=false;
			    }
				$this->chars=$this->chars.trim($text);
			}
        }

       function flushChars(){
            if (strlen($this->chars)>0) {
				if ($this->closed) {
					print "\n".str_repeat(' ',$this->indent);
					$this->closed=false;
					               }
				print preg_replace("/ *\n? +/"," ",$this->chars);
				$this->closed=true;
				$this->chars="";
			}
        }
}
?>