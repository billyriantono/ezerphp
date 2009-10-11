<?php
require_once dirname(__FILE__) . '/../case/Ezer_SequenceInstance.php';
require_once 'Ezer_StepContainer.php';

/**
 * Project:     PHP Ezer business process manager
 * File:        Ezer_Sequence.php
 * Purpose:     Store in the memory the definitions of a sequence
 * 
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 * For questions, help, comments, discussion, etc., please send
 * e-mail to tan-tan@simple.co.il
 *
 * @author Tan-Tan
 * @package Engine
 * @subpackage Process.Logic
 */
class Ezer_Sequence extends Ezer_StepContainer
{
	public function createInstance(Ezer_BusinessProcessInstance $process_instance)
	{
		return new Ezer_SequenceInstance($process_instance, $this);
	}
	
	public function add(Ezer_Step $step)
	{
		// overwrite any flow definition
		$step->in_flows = array();
		$step->out_flows = array();
		
		parent::add($step);
		
		$last_index = count($this->steps) - 1;
		if($last_index <= 0)
			return;
			
		$last_step = &$this->steps[$last_index];
		$prev_step = &$this->steps[$last_index - 1];
		$last_step->in_flows[$prev_step->id] = $prev_step;
		$prev_step->out_flows[$last_step->id] = $last_step;
	}
}

?>