<?php
/**
* admin / menu
* az admin controllerbe van includolva
*/
$interval = $this->request->input('interval','week');
// adat lekérés az adatbázisból
$menuLabels = [];
if ($interval == 'week') {
    for ($i = 7; $i >= 0; $i--) {
        $menuLabels[] = date('m.d', time() - $i*24*60*60);
    }    
}    
if ($interval == 'month') {
    for ($i = 30; $i >= 0; $i--) {
        $menuLabels[] = date('m.d', time() - $i*24*60*60);
    }    
}    
if ($interval == 'year') {
    for ($i = 365; $i >= 0; $i--) {
        $menuLabels[] = date('m.d', time() - $i*24*60*60);
    }    
}    
$menuDatas = $this->model->getMenuDatas($interval);

?>
<div class="col-md-12">
    <div class="adminBox adminBox0">
        <h2>Új napi menü statisztika</h2>
        <canvas id="myChart2" width="400" height="300"></canvas>
        <p>
            <a href="index.php?task=admin&act=adminmenu&interval=week" 
                class="<?php if ($interval == 'week') echo 'current'; ?>">
                Hét</a>&nbsp; &nbsp;
            <a href="index.php?task=admin&act=adminmenu&interval=month" 
                class="<?php if ($interval == 'month') echo 'current'; ?>">
                Hónap</a>&nbsp; &nbsp;
            <a href="index.php?task=admin&act=adminmenu&interval=year" 
                class="<?php if ($interval == 'year') echo 'current'; ?>">
                Év</a>
        </p>
    </div>    
</div>
<script>
    window.setTimeout(function() {
            var data = {
                labels: <?php echo JSON_encode($menuLabels); ?>,
                datasets: [{data: <?php echo JSON_encode($menuDatas); ?>,
                           label:'menu', 
                           backgroundColor:'blue', borderColor:'blue'}]
            };   
            var ctx = document.getElementById('myChart2').getContext('2d');
            const config2 = {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: ''
                    }
                    }
                },
            };
            const myChart2 = new Chart(ctx, config2);
    },1000);
</script>    