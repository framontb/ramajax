<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>

<!-- Title -->
<hr>
<h1 class="bg-info"><?php echo JText::_('RAMAJAX_SEARCH') ?></h1>

<form action="index.php?option=com_ramajaxuseexample&view=buscador" method="post" id="adminForm" name="adminForm">

    <!-- ************************ SEARCH **************************** -->
    <button  id="filter_clear" class="btn btn-large"  type="Button"> <?php echo JText::_('RAMAJAX_BUTTON_RESET') ?> </button>
    <input type="submit" class="btn btn-large btn-primary" value="<?php echo JText::_('RAMAJAX_BUTTON_SUBMIT') ?>">
    <hr>

    <!-- filters -->
    <h2><?php echo JText::_('RAMAJAX_FILTERS') ?></h2>
    <div class="row-fluid">
        <div class="span6 center bg-info" style="background-color: lightblue;">
            <h2><?php echo JText::_('RAMAJAX_SPORTS') ?></h2>
            <?php echo $this->filterForm->renderField('league','filter'); ?>
            <hr>
            <?php echo $this->filterForm->renderField('team',  'filter'); ?>
            <hr>
            <?php echo $this->filterForm->renderField('player','filter'); ?>
        </div>
        <div class="span6 center bg-dark"  style="background-color: lightgreen;">
            <h2><?php echo JText::_('RAMAJAX_ORIGIN') ?></h2>
            <?php echo $this->filterForm->renderField('player_country','filter'); ?>
            <hr>
            <?php echo $this->filterForm->renderField('player_state',  'filter'); ?>
            <hr>
            <?php echo $this->filterForm->renderField('player_city',   'filter'); ?>
        </div>
    </div>
    <!-- ************************ RESULTS **************************** -->
    <hr>
    <h1><?php echo JText::_('RAMAJAX_RESULTS') ?></h1>
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th width="10%">
                <?php echo JText::_('LEAGUE') ;?>
            </th>
            <th width="20%">
                <?php echo JText::_('COM_RAMAJAXUSEEXAMPLE_TEAM') ;?>
            </th>
            <th width="20%">
                <?php echo JText::_('PLAYER') ;?>
            </th>
            <th width="20%">
                <?php echo JText::_('PLAYER_COUNTRY') ;?>
            </th>
            <th width="10%">
                <?php echo JText::_('PLAYER_STATE') ;?>
            </th>
            <th width="20%">
                <?php echo JText::_('PLAYER_CITY') ;?>
            </th>
            <th width="10%">
                <?php echo JText::_('WAGE') ;?>
            </th>
        </tr>
        </thead>
        <tfoot>
            <tr>
                <td colspan="5">
                    <?php echo $this->pagination->getListFooter(); ?>
                    <?php echo $this->filterForm->renderField('limit', 'list');  ?>
                </td>
            </tr>
        </tfoot>
        <tbody>
            <?php if (!empty($this->items)) : ?>
                <?php foreach ($this->items as $i => $row) : ?>

                    <tr>
                        <td>
                            <?php echo JText::_($row->league); ?>
                        </td>
                        <td>
                            <?php echo JText::_($row->team); ?>
                        </td>
                        <td>
                            <?php echo $row->player; ?>
                        </td>
                        <td>
                            <?php echo JText::_($row->player_country); ?>
                        </td>
                        <td>
                            <?php echo JText::_($row->player_state); ?>
                        </td>
                        <td>
                            <?php echo JText::_($row->player_city); ?>
                        </td>
                        <td>
                            <?php echo $row->wage; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <input type="hidden" name="langTag" id="langTag" value="<?php echo $this->langTag; ?>" />
    <input type="hidden" name="task" />
	<?php echo JHtml::_('form.token'); ?>
</form>