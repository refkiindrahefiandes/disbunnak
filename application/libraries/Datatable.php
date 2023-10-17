<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Class Datatable
* @author	Masriadi
*/
class Datatable
{
	public function index($config = array())
	{
        $CI =& get_instance();

        $model_name          = $config['model_name'];
        $sIndexColumn        = $config['sIndexColumn'];
        $table_name          = $config['table_name'];
        $table_join_name     = $config['table_join_name'];
        $table_join_col_name = $config['table_join_col_name'];
        $search_col_name     = $config['search_col_name'];
        $where_options    	 = $config['where_options'];
        $aColumns            = $config['aColumns'];

        $CI->load->model('blog/' . $model_name);

        // paging
        $sLimit = "";
        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ){
            $sLimit = "LIMIT ".$_GET['iDisplayStart'].", ".
                $_GET['iDisplayLength'];
        }
        $numbering = $_GET['iDisplayStart'];
        $page = 1;

        // ordering
        $sOrder = NULL;
        if ( isset( $_GET['iSortCol_0'] ) ){
            $sOrder = "ORDER BY  ";
            for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ){
                if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ){
                    if ($aColumns[ intval( $_GET['iSortCol_'.$i] ) ] == $table_join_col_name) {
                        $sOrder .= $table_join_name.'.'. $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".$_GET['sSortDir_'.$i] .", ";
                    } else {
                        $sOrder .= $table_name.'.' . $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]." ".$_GET['sSortDir_'.$i] .", ";
                    }
                }
            }

            $sOrder = substr_replace( $sOrder, "", -2 );
            if ( $sOrder == "ORDER BY" ){
                $sOrder = "";
            }
        } else {
            $sOrder = "ORDER BY " . $table_name . '.' . $sIndexColumn . " DESC";
        }

        // options filtering
        $oWhere = "";
        if (! empty($where_options)) {
            foreach ($where_options as $key => $value) {
                $string[] = '(' . $key. '=' . '\'' . $value . '\'' . ')';
            }

            $where = implode(' AND ', $string);

            if ($table_join_name != NULL) {
                $oWhere = "AND " . $where;
            } else {
                $oWhere = "WHERE " . $where;
            }
        }

        // search filtering
        $sWhere = "";
        if ( $_GET['sSearch'] != "" ){
            if ($table_join_name !=NULL) {
                $sWhere = "AND (";
                $sWhere .= $table_join_name.'.'.$search_col_name ." LIKE '%".$_GET['sSearch']."%'";
                $sWhere .= ')';

            } elseif(! empty($where_options)) {
                $sWhere = "AND (";
                $sWhere .= $search_col_name ." LIKE '%".$_GET['sSearch']."%'";
                $sWhere .= ')';
            } else {
                $sWhere = "WHERE (";
                $sWhere .= $search_col_name ." LIKE '%".$_GET['sSearch']."%'";
                $sWhere .= ')';
            }
        }

        // Send query to model
        $rResult = $CI->$model_name->get_datatables($sIndexColumn, $oWhere, $sWhere, $sOrder, $sLimit, $table_name, $table_join_name);
        $iFilteredTotal = 10;
        $rResultTotal = $CI->$model_name->get_datatable_total($sIndexColumn, $oWhere, $table_name, $table_join_name);
        $iTotal = $rResultTotal->num_rows();
        $iFilteredTotal = $iTotal;

        $output = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $iTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );

        foreach ($rResult->result_array() as $aRow){
            $row = array();
            for ( $i=0 ; $i<count($aColumns) ; $i++ ){
                $row[] = $aRow[ $aColumns[$i] ];
            }
            $page++;

            $output['aaData'][] = $row;
        }

        return $output;
	}
}