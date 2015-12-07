<!-- /* 
 * Copyright (C) 2015 Mevlüt Canvar <info@mcnvr.com>
 *
 * TCMB XML ÖDEVİ: 2015/2016 Güz Dönemi Web Servisleri Ödevi(Sunucu Tabanlı)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */ -->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>TCMB Kurları</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="css/bootstrap-table.min.css" />
	
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">
	
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="css/bootstrap-theme.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
	<?php
		$datetime = getIMKBDatetimeNow();
		
		if((int)$datetime->format('G') < 16)
			$datetime->modify('-1 day');
		
		if($datetime->format('N') > 5){
			if($datetime->format('N') == 6) {
				$dayOfDate = $datetime->modify('-1 day')->format('d');
				$monthOfDate = $datetime->format('m');
				$yearOfDate = $datetime->format('Y');
				$TheDayBefore = $datetime->modify('-1 day')->format('d');
				$TheMonthBefore = $datetime->format('m');
				$TheYearBefore = $datetime->format('Y');
			} else {
				$dayOfDate = $datetime->modify('-2 day')->format('d');
				$monthOfDate = $datetime->format('m');
				$yearOfDate = $datetime->format('Y');
				$TheDayBefore = $datetime->modify('-1 day')->format('d');
				$TheMonthBefore = $datetime->format('m');
				$TheYearBefore = $datetime->format('Y');
			}
		}
		else {
			if($datetime->format('N') == 1) {
				$dayOfDate = $datetime->format('d');
				$monthOfDate = $datetime->format('m');
				$yearOfDate = $datetime->format('Y');
				$TheDayBefore = $datetime->modify('-3 day')->format('d');
				$TheMonthBefore = $datetime->format('m');
				$TheYearBefore = $datetime->format('Y');
			} else {
				$dayOfDate = $datetime->format('d');
				$monthOfDate = $datetime->format('m');
				$yearOfDate = $datetime->format('Y');
				$TheDayBefore = $datetime->modify('-1 day')->format('d');
				$TheMonthBefore = $datetime->format('m');
				$TheYearBefore = $datetime->format('Y');
			}
		}
		
		$xmlOfTheDay = 'http://www.tcmb.gov.tr/kurlar/'.$yearOfDate.$monthOfDate.'/'.$dayOfDate.$monthOfDate.$yearOfDate.'.xml';
		$xmlOfTheDayBefore = 'http://www.tcmb.gov.tr/kurlar/'.$TheYearBefore.$TheMonthBefore.'/'.$TheDayBefore.$TheMonthBefore.$TheYearBefore.'.xml';
		
		function getIMKBDatetimeNow() {
		$tz_object = new DateTimeZone('Europe/Istanbul');

		$datetime = new DateTime();
		$datetime->setTimezone($tz_object);

		return $datetime;
		}
		$xml = simplexml_load_file($xmlOfTheDay);
		$xml2 = simplexml_load_file($xmlOfTheDayBefore);
	?>
    <nav class="navbar navbar-default navbar-fixed-top">
		<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="/"><strong>DÖVİZ ÇEVİRİCİ</strong></a>
				</div>
			<div id="navbar" class="collapse navbar-collapse">
				<div class="row">
					<div class="col-sm-2">
						<div class="btn-group btn-group-justify" id="changeType" data-toggle="buttons" role="group" aria-label="...">
							<label class="btn btn-success active">
								<input type="radio" name="options" id="option1" autocomplete="off" checked> <strong>ALIŞ</strong>
							</label>
							<label class="btn btn-success">
								<input type="radio" name="options" id="option2" autocomplete="off"> <strong>SATIŞ</strong>
							</label>
						</div>
					</div><!-- /.col-lg-4 -->
					<div class="col-lg-4">
						<div class="input-group">
						  <input type="text" id="currencyLeft" class="form-control" value="1"  data-toggle="tooltip" data-placement="bottom" title="Görüntülenen bir para birimi için değer giriniz.">
						  <div class="input-group-btn">
							<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="currencyCodeLeft">TRY<span class="caret"></span></button>
							<ul class="dropdown-menu dropdown-menu-right" id="mydropdownmenu">
								<?php
								foreach ($xml->Currency as $Currency) {
									if ($Currency['Kod'] != "XDR")
										echo "<li><a href='#'><img src='imgs/".$Currency['CurrencyCode'].".gif' />".$Currency['Kod']."</a></li>";
								}
								?>
								<li><a href='#'><img src='imgs/TRY.gif' />TRY</a></li>
							</ul>
						  </div><!-- /btn-group -->
						</div><!-- /input-group -->
					</div><!-- /.col-lg-4 -->
					<div class="col-lg-4">
						<div class="input-group">
						  <input type="text" id="currencyRight" class="form-control" value="<?php echo 1 / floatval($xml->Currency[0]->ForexBuying); ?>" data-toggle="tooltip1" data-placement="bottom" title="Görüntülenen bir para birimi için değer giriniz.">
						  <div class="input-group-btn">
							<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="currencyCodeRight">USD<span class="caret"></span></button>
							<ul class="dropdown-menu dropdown-menu-right" id="mydropdownmenu1">
								<?php
								foreach ($xml->Currency as $Currency) {
									if ($Currency['Kod'] != "XDR")
										echo "<li><a href='#'><img src='imgs/".$Currency['CurrencyCode'].".gif' />".$Currency['Kod']."</a></li>";
								}
								?>
								<li><a href='#'><img src='imgs/TRY.gif' />TRY</a></li>
							</ul>
						  </div><!-- /btn-group -->
						</div><!-- /input-group -->
					</div><!-- /.col-lg-4 -->
				</div>
			</div><!--/.nav-collapse -->
		</div>
    </nav>

    <div class="container">
		<div class="row row-offcanvas row-offcanvas-right">
			<div class="jumbotron">
				<h2>TCMB KUR SAYFASI</h2>
				<p>
				<?php echo $dayOfDate.'.'.$monthOfDate.'.'.$yearOfDate; ?> Günü Saat 15:30'da Belirlenen Gösterge Niteliğindeki Türkiye Cumhuriyet Merkez Bankası Kurları
				</p>
			</div>
			<table id="table"
				cellSpacing="0"
				data-toggle="table"
				className="table table-striped table-bordered table-hover"
				data-show-toggle="true"
				data-show-export="true"
				data-show-columns="true"
				data-height="600"
				data-row-style="rowStyle"
				data-show-footer="false"
				data-minimum-count-columns="2"
				data-page-list="[5, 10]"
				data-show-pagination-switch="true"
				data-pagination="true">
				<thead>
				<tr>
					<th data-field="CurrencyCode">Döviz Kodu</th>
					<th data-field="Unit">Birim</th>
					<th data-field="Isim">Döviz Cinsi</th>
					<th data-field="ForexBuying">Döviz Alış</th>
					<th data-field="ForexSelling">Döviz Satış</th>
					<th data-field="BanknoteBuying">Efektif Alış</th>
					<th data-field="BanknoteSelling">Efektif Satış</th>
					<th data-field="Difference">Değişim</th>
				</tr>
				</thead>
				<tbody>
					<?php for ($i = 0; $i < count($xml) && $i < count($xml2); ++$i) { ?>
						<?php if ($xml->Currency[$i]['Kod'] != "XDR") { ?>
							<tr>
								<td><img src="imgs/<?php echo $xml->Currency[$i]['CurrencyCode']; ?>.gif" class="img-thumbnail" /><?php echo " ".$xml->Currency[$i]['CurrencyCode']." / TRY"; ?></td>
								<td id="ForexUnit<?php echo $xml->Currency[$i]['Kod'] ?>" class="text-center"><?php echo $xml->Currency[$i]->Unit; ?></td>
								<td><?php echo $xml->Currency[$i]->Isim; ?></td>
								<td id="ForexBuying<?php echo $xml->Currency[$i]['Kod'] ?>" class="text-center"><?php echo round(floatval($xml->Currency[$i]->ForexBuying),4); ?></td>
								<td id="ForexSelling<?php echo $xml->Currency[$i]['Kod'] ?>" class="text-center"><?php echo round(floatval($xml->Currency[$i]->ForexSelling),4); ?></td>
								<td class="text-center"><?php echo round(floatval($xml->Currency[$i]->BanknoteBuying),4); ?></td>
								<td class="text-center"><?php echo round(floatval($xml->Currency[$i]->BanknoteSelling),4); ?></td>
								<td class="text-center"><?php 
									$differenceOfCurrency = floatval($xml->Currency[$i]->ForexSelling) - floatval($xml2->Currency[$i]->ForexSelling);
									$perDifferenceOfCurrency = round(($differenceOfCurrency / floatval($xml->Currency[$i]->ForexSelling) * 100), 4);
									if($perDifferenceOfCurrency < 0.0)
										echo "<span class='label label-danger'><span class='glyphicon glyphicon-chevron-down' aria-hidden='true'></span> %".abs($perDifferenceOfCurrency)."</span>";
									else if($perDifferenceOfCurrency == 0.0)
										echo "<span class='label label-default'> %".$perDifferenceOfCurrency."</span>";
									else
										echo "<span class='label label-primary'><span class='glyphicon glyphicon-chevron-up' aria-hidden='true'></span> %".$perDifferenceOfCurrency."</span>";
								?></td>
							</tr>
						<?php } ?>
					<?php }	?>
				</tbody>
			</table>
		</div><!--/row-->
		
		<br />
		<small>Bu veriler TCMB'nın <a href="http://www.tcmb.gov.tr/kurlar/today.xml" target="_blank">xml</a> kaynaklarından yararlanılarak yayınlanmaktadır.</small>
		<hr>

		<footer>
			<p>&copy; 2015 Web Services Ödevi, Mühendislik Fakültesi, Karabük Üniversitesi</p>
		</footer>
	</div><!-- /.container -->

	
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-table.min.js"></script>
	<script src="js/tableExport.min.js"></script>
	<script src="js/bootstrap-table-export.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>

    <!-- Converter -->
	<script type="text/javascript">		
		$(document).ready(function(){
			$('#currencyLeft, #mydropdownmenu').bind('keypress click', function () {
				var self = $(this);

				clearTimeout(self.data('timeout'));
				
				if($("#changeType label.active input").attr("id") == "option1") {
					var strOfIdLeft = "#ForexBuying" + $("#currencyCodeLeft").text();
					var strOfIdRight = "#ForexBuying" + $("#currencyCodeRight").text();
				} else {
					var strOfIdLeft = "#ForexSelling" + $("#currencyCodeLeft").text();
					var strOfIdRight = "#ForexSelling" + $("#currencyCodeRight").text();
				}
				
				if($("#currencyCodeLeft").text() == 'TRY') {
					self.data('timeout', setTimeout(function() {
						$("#currencyRight").val( $("#currencyLeft").val() / $( strOfIdRight ).text() );
					}, 100));
				} else if($("#currencyCodeRight").text() == 'TRY') {
					self.data('timeout', setTimeout(function() {
						$("#currencyRight").val( $("#currencyLeft").val() * $( strOfIdLeft ).text() );
					}, 100));
				} else {
					self.data('timeout', setTimeout(function() {
						$("#currencyRight").val( $("#currencyLeft").val() * $( strOfIdLeft ).text() / $( strOfIdRight ).text() );
					}, 100));
				}
			});
			
			$('#currencyRight, #mydropdownmenu1').bind('keypress click', function () {
				var self = $(this);

				clearTimeout(self.data('timeout'));
				
				if($("#changeType label.active input").attr("id") == "option1") {
					var strOfIdLeft = "#ForexBuying" + $("#currencyCodeLeft").text();
					var strOfIdRight = "#ForexBuying" + $("#currencyCodeRight").text();
				} else {
					var strOfIdLeft = "#ForexSelling" + $("#currencyCodeLeft").text();
					var strOfIdRight = "#ForexSelling" + $("#currencyCodeRight").text();
				}
				
				if($("#currencyCodeRight").text() == 'TRY') {
					self.data('timeout', setTimeout(function() {
						$("#currencyLeft").val( $("#currencyRight").val() / $( strOfIdLeft ).text() );
					}, 100));
				} else if($("#currencyCodeLeft").text() == 'TRY') {
					self.data('timeout', setTimeout(function() {
						$("#currencyLeft").val( $("#currencyRight").val() * $( strOfIdRight ).text() );
					}, 100));
				} else {
					self.data('timeout', setTimeout(function() {
						$("#currencyLeft").val( $("#currencyRight").val() * $( strOfIdRight ).text() / $( strOfIdLeft ).text() );
					}, 100));
				}
			});
		});
	</script>
	
    <!-- Dropdown select -->
	<script type="text/javascript">
		$(document).ready(function() {
			$(".dropdown-menu li a").click(function(){			
			var selText = $(this).text();
			$(this).closest('div').find('button[data-toggle="dropdown"]').html(selText + '<span class="caret"></span>');
			});
			
			$(function () {
			  $('[data-toggle="tooltip"]').tooltip()
			})
			$(function () {
			  $('[data-toggle="tooltip1"]').tooltip()
			})
		});
	</script>
    <!-- Table -->
	<script>
		var $table = $('#table');
		$(function () {
		});
	</script>
  </body>
</html>
