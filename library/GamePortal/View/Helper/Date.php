<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * mise en forme des date de la bdd
 * 
 */

class GamePortal_View_Helper_Date extends Zend_View_Helper_Abstract
{
    /**
     * 
     * formate la date de mysql pour l'affichage. 
     * format rendu :
     * 'le jour  mois  année   à HHhmm'
     *  ou
     * 'aujourd'hui/hier à HHhmm' 
     * 
     * @param int $date le timestamp de la date.
     */
    public function date($date) {
        
        $now = Zend_Date::now();
        $full_date = new Zend_Date($date);
        
        $output_date = ' le ' . $full_date->get(Zend_Date::WEEKDAY) .
                ' ' . $full_date->get(Zend_Date::DAY) .
                ' ' . $full_date->get(Zend_Date::MONTH_NAME);    
        
        if ($full_date->isEarlier($now, $now->get(Zend_Date::YEAR)) || $full_date->isLater($now, $now->get(Zend_Date::YEAR))){
            $output_date .= ' '.$full_date->get(Zend_Date::YEAR);
        }
            $output_date .= ' à ' . $full_date->get(Zend_Date::HOUR) . 'h' . $full_date->get(Zend_Date::MINUTE);
               

        if ($full_date->isToday()) {

            $output_date = 'aujourd\'hui à ' . $full_date->get(Zend_Date::HOUR) . 'h' . $full_date->get(Zend_Date::MINUTE);
        } elseif ($full_date->isYesterday()) {

            $output_date = 'hier à ' . $full_date->get(Zend_Date::HOUR) . 'h' . $full_date->get(Zend_Date::MINUTE);
        }       

        return $output_date;
    }
}