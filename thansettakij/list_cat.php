<!-- <!DOCTYPE html> -->
<html lang="th">
    <head>
	<meta charset="utf-8"/>
    <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport"/>
	<title>Check Category thansettakij</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;300&display=swap" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
	<style>
	body{
		font-family: 'Kanit', sans-serif;
	}
    .container1{
        align:center;
    }
    table {
        background-color: #ffffff;
        font-size: 16px;
        border-collapse: collapse;
    }
    table.table-concept tr th {
        color: #ffffff;
        font-weight: normal;
        background-color: #8f8f8f;
        border-bottom: solid 2px #d8d8d8;
        position: sticky;
        top: 0;
    }
    table.table-concept tbody tr {
        transition: background-color 150ms ease-out;
    }
    table.table-concept tbody tr:nth-child(2n) {
        background-color: whitesmoke;
    }
	</style>
</head>
<body>
    <div class="container1" >
        <h1>Check Category thansettakij</h1>
        
        <table id="table-list" width="98%" class="table-concept">
            <thead>
            <tr>
                <th>Category</th>
                <th>Subcat</th>
                <th>URL</th>
                <th>Canonical</th>
                <th>Title</th>
                <th>Description</th>
                <th>keyword</th>
                <th>H1</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Home</td>
                <td></td>
                <td id="url1">https://www.thansettakij.com/</td>
                <td><div id="canonical1"></div></td>
                <td><div id="title1"></div></td>
                <td><div id="description1"></div></td>
                <td><div id="keyword1"></div></td>
                <td><div id="h1_1"></div></td>
                <td></td>
            </tr>
            
            </tbody>
        </table>
    </div>
<script defer src="https://kit.fontawesome.com/425fce21f6.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        init_cat();
        get_data(1);
	});

function init_cat(){
    var url = 'https://api.thansettakij.com/api/v1.0/navigations/menu-nav';
    var base_url = 'https://www.thansettakij.com/';
    var sub;
    var nameTh;
    var catid;
    var link;
    var curlink;
    var delay = 1000;

    $.ajax({
        type:"GET",
        url: url,
        success:function(rsponse){

            // console.log('res:' + rsponse); 

            for(var k in rsponse) {
                // console.log(k, rsponse[k]);

                catid = rsponse[k].id;
                nameTh = rsponse[k].nameTh;
                link = rsponse[k].link;

                console.log('id', rsponse[k].id);
                // console.log('nameEng', rsponse[k].nameEng);
                console.log('nameTh', rsponse[k].nameTh);
                console.log('link', rsponse[k].link);

                curlink = base_url + link;

                $('#table-list').append('<tr><td>' + nameTh + '</td><td></td><td id="url' + catid + '">' + curlink + '</td><td><div id="canonical' + catid + '"></div></td><td><div id="title' + catid + '"></div></td><td><div id="description' + catid + '"></div></td><td><div id="keyword' + catid + '"></div></td><td><div id="h1_' + catid + '"></div></td><td></td></tr>');
                
                setTimeout(get_data(catid), delay);
                delay = delay + 100;
                

                sub = rsponse[k].sub;
                for(var j in sub) {
                    // console.log(j, sub[j]);

                    subcatid = sub[j].id;
                    nameTh = sub[j].nameTh;
                    link = sub[j].link;

                    curlink = 'https://www.thansettakij.com' + link;

                    console.log('id', sub[j].id);
                    // console.log('nameEng', sub[j].nameEng);
                    console.log('nameTh', sub[j].nameTh);
                    console.log('link', sub[j].link);

                    $('#table-list').append('<tr><td></td><td>' + nameTh + '</td><td id="url' + subcatid + '">' + curlink + '</td><td><div id="canonical' + subcatid + '"></div></td><td><div id="title' + subcatid + '"></div></td><td><div id="description' + subcatid + '"></div></td><td><div id="keyword' + subcatid + '"></div></td><td><div id="h1_' + subcatid + '"></div></td><td></td></tr>');
                    
                    setTimeout(get_data(subcatid), delay);
                    delay = delay + 100;
                }

            }

            // $("#title" + id).html(rsponse.title);
            // $("#description" + id).html(rsponse.description);
            // $("#keyword" + id).html(rsponse.keyword);
            // $("#h1_" + id).html(rsponse.h1);
            // $("#canonical" + id).html(rsponse.canonical);

        }
    });
}

function get_data(id){

    var url = $("#url" + id).html();
    console.log('url:' + url);

    $.ajax({
        type:"POST",
        url: "res_api.php",
        data: {than_url : url},
        cache:false,
        success:function(rsponse){

            $("#title" + id).html(rsponse.title);
            $("#description" + id).html(rsponse.description);
            $("#keyword" + id).html(rsponse.keywords);
            $("#h1_" + id).html(rsponse.h1);
            $("#canonical" + id).html(rsponse.canonical);

            // console.log('res:' + rsponse);
            // alert('Update team_id:' + team_id + ' ==> ' + team_name_th);
        }
    });
}
</script>
</body>
</html>