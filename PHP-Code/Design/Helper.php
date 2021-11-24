<?php
class Helper{
//Short function for implementing a Confirm-Button
    public static function printButton(){
        readfile('../tpl/submitButton.tpl');
    }
    public static function printFooter(){
        readfile('../tpl/footer.tpl');
    }
    public static function printHeader(){
       readfile('../tpl/header.tpl');
    }
}