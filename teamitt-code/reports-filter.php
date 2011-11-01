
<script type="text/javascript" charset="utf-8">
Date.firstDayOfWeek = 0;
Date.format = 'yyyy-mm-dd';
$(function()
		{
		$('#rfd').datePicker({clickInput:false,startDate: '1970-01-01', endDate: (new Date()).asString() });
		$('#rtd').datePicker({clickInput:false,startDate: '1970-01-01', endDate: (new Date()).asString()});
		});
</script>
<form id ='filter-form'>
<ol>
<li>
<select name='report-options'>
<option value="1">Choose Date </option>
<option value ="2">Choose time Range </option>
</select>
</li>

<div class='in-div' option='1'>
<li>
<label for='rfd'>From Date</label>
<input type='text' id ='rfd' disabled=disabled></input>
</li>
<li>
<label for='rfd'>To Date</label>
<input type='text' id ='rtd' disabled=disabled></input>
</li>
</div >
<div class='in-div' option='2' style='display:none;'>
<li>
<select name='time-range'>
<option value='DAY'>Today </option>
<option value='TWEEK'>This Week </option>
<option value='LWEEK'>Last Week </option>
<option value='TMONTH'>This Month </option>
<option value='LMONTH'>Last Month </option>
<option value='TYEAR'>This Year </option>
<option value='LYEAR'>Last Year </option>
</select>
</li>
</div>
<br/>
<br/>
<li>
<input type='submit' class='submit' value='Filter'></input>
</li>
</ol>
</form>
