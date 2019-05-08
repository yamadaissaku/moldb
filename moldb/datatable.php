<?php
session_start();
// ログイン状態チェック
if (!isset($_SESSION["NAME"])) {
    header("Location: Logout.php");
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>


    <!-- <link rel="stylesheet" href="../css/site.min.css"> -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,800,700,400italic,600italic,700italic,800italic,300italic" rel="stylesheet" type="text/css">
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
    


</head>

<body>


    <script>
        $.ajax({ // json読み込み開始
                type: 'GET',
                // JSON API URL
                url: 'http://localhost:8888/moldb/sql-select.php?limit=4000&offset=0',
                dataType: 'json'
            })
            .then(
                function(json) { // jsonの読み込みに成功した時
                    console.log('成功');
                    console.log(json);
                    $(function() {
                        $('#example').DataTable({
                            // 件数切替機能 無効
                            lengthChange: false,
                            // 検索機能 無効
                            searching: true,
                            // ソート機能 無効
                            ordering: true,
                            // 情報表示 無効
                            info: true,
                            // ページング機能 無効
                            //paging: true,

                            paging: false,
                            scrollY:"80vh",
                            scrollCollapse: true,

                            // 状態を保存する機能をつける
                            stateSave: true,

                            hover: true,
                            // 大量データ利用時、「処理中」メッセージを表示するかを設定
                            bProcessing: true,
                            // 初期表示の行数設定
                            //iDisplayLength: 25,
                            //検索（フィルタ）を表示するかを設定
                            bFilter: false,
                            // ヘッダを固定
                            fixedHeader: true,

                            //destroy: true,

                            data: json,
                            columns: [{
                                    // id
                                    data: 'molid',
                                    "render": function(data) {
                                        return '<a href="molentry.php?id=' + data + '" target="_blank" >' + data + '</a>';
                                    }
                                },
                                {
                                    data: 'PUBCHEM_COMPOUND_CID'
                                },
                                {
                                    data: 'PUBCHEM_CACTVS_HBOND_ACCEPTOR'
                                },
                                {
                                    data: 'PUBCHEM_CACTVS_HBOND_DONOR'
                                },
                                //{
                                //    data: 'PUBCHEM_IUPAC_OPENEYE_NAME'
                                //},
                                {
                                    data: 'PUBCHEM_IUPAC_NAME'
                                },
                                {
                                    data: 'PUBCHEM_IUPAC_INCHIKEY'
                                },
                                {
                                    data: 'PUBCHEM_MOLECULAR_FORMULA'
                                },
                                {
                                    data: 'PUBCHEM_MOLECULAR_WEIGHT'
                                },
                                {
                                    data: 'molid',
                                    "render": function(data) {
                                        //return '<img src="img.php?id=' + data + '" width="200" />';
                                        return '<img src="./img/' + data + '.png" width="200" />';
                                    }
                                },
                                {
                                    data: 'created'
                                }
                            ]
                        });
                    })
                },
                function() { //jsonの読み込みに失敗した時
                    console.log('データ取得失敗');
                }
            );
    </script>
<!-- 
    <script>
        function filterGlobal () {
            $('#example').DataTable().search(
                $('#global_filter').val(),
                $('#global_regex').prop('checked'),
                $('#global_smart').prop('checked')
            ).draw();
        }
         
        function filterColumn ( i ) {
            $('#example').DataTable().column( i ).search(
                $('#col'+i+'_filter').val(),
                $('#col'+i+'_regex').prop('checked'),
                $('#col'+i+'_smart').prop('checked')
            ).draw();
        }
         
        $(document).ready(function() {
            $('#example').DataTable();
         
            $('input.global_filter').on( 'keyup click', function () {
                filterGlobal();
            } );
         
            $('input.column_filter').on( 'keyup click', function () {
                filterColumn( $(this).parents('tr').attr('data-column') );
            } );
        } );
    </script>


<table cellpadding="3" cellspacing="0" border="0" style="width: 67%; margin: 0 auto 2em auto;">
        <thead>
            <tr>
                <th>Target</th>
                <th>Search text</th>
                <th>Treat as regex</th>
                <th>Use smart search</th>
            </tr>
        </thead>
        <tbody>
            <tr id="filter_global">
                <td>Global search</td>
                <td align="center"><input type="text" class="global_filter" id="global_filter"></td>
                <td align="center"><input type="checkbox" class="global_filter" id="global_regex"></td>
                <td align="center"><input type="checkbox" class="global_filter" id="global_smart" checked="checked"></td>
            </tr>
            <tr id="filter_col1" data-column="0">
                <td>Column - molID</td>
                <td align="center"><input type="text" class="column_filter" id="col0_filter"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col0_regex"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col0_smart" checked="checked"></td>
            </tr>
            <tr id="filter_col2" data-column="1">
                <td>Column - CID</td>
                <td align="center"><input type="text" class="column_filter" id="col1_filter"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col1_regex"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col1_smart" checked="checked"></td>
            </tr>
            <tr id="filter_col3" data-column="2">
                <td>Column - HBOND_ACCEPTOR</td>
                <td align="center"><input type="text" class="column_filter" id="col2_filter"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col2_regex"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col2_smart" checked="checked"></td>
            </tr>
            <tr id="filter_col4" data-column="3">
                <td>Column - HBOND_DONOR</td>
                <td align="center"><input type="text" class="column_filter" id="col3_filter"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col3_regex"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col3_smart" checked="checked"></td>
            </tr>
            <tr id="filter_col5" data-column="4">
                <td>Column - OPENEYE_NAME</td>
                <td align="center"><input type="text" class="column_filter" id="col4_filter"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col4_regex"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col4_smart" checked="checked"></td>
            </tr>
            <tr id="filter_col6" data-column="5">
                <td>Column - IUPAC_NAME</td>
                <td align="center"><input type="text" class="column_filter" id="col5_filter"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col5_regex"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col5_smart" checked="checked"></td>
            </tr>
            <tr id="filter_col7" data-column="6">
                <td>Column - INCHIKEY</td>
                <td align="center"><input type="text" class="column_filter" id="col6_filter"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col6_regex"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col6_smart" checked="checked"></td>
            </tr>
            <tr id="filter_col8" data-column="7">
                <td>Column - FORMULA</td>
                <td align="center"><input type="text" class="column_filter" id="col7_filter"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col7_regex"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col7_smart" checked="checked"></td>
            </tr>
            <tr id="filter_col9" data-column="8">
                <td>Column - MOLECULAR_WEIGHT</td>
                <td align="center"><input type="text" class="column_filter" id="col8_filter"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col8_regex"></td>
                <td align="center"><input type="checkbox" class="column_filter" id="col8_smart" checked="checked"></td>
            </tr>

        </tbody>
    </table>
-->


    <table id='example' class="cell-border compact hover stripe display">
        <thead>
            <tr>
                <th>molID</th>
                <th>CID</th>
                <th>HBOND_ACCEPTOR</th>
                <th>HBOND_DONOR</th>
                <!-- <th>OPENEYE_NAME</th> -->
                <th>IUPAC_NAME</th>
                <th>INCHIKEY</th>
                <th>FORMULA</th>
                <th>MOLECULAR_WEIGHT</th>
                <th>IMAGE</th>
                <th>created</th>
            </tr>
        <!-- 
            <tr>
                <td><input type="text" data-column="0" class="search-input-text"></td>
                <td><input type="text" data-column="1" class="search-input-text"></td>
                <td><input type="text" data-column="2" class="search-input-text"></td>
                <td><input type="text" data-column="3" class="search-input-text"></td>
                <td><input type="text" data-column="4" class="search-input-text"></td>
                <td><input type="text" data-column="5" class="search-input-text"></td>                
                <td><input type="text" data-column="6" class="search-input-text"></td>
                <td><input type="text" data-column="7" class="search-input-text"></td>
                <td><input type="text" data-column="8" class="search-input-text"></td>
                <td><input type="text" data-column="9" class="search-input-text"></td>
                <td><input type="text" data-column="10" class="search-input-text"></td>
            </tr>
        -->

        </thead>
    </table>

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
</body>

</html> 

