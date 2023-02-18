
<script type="text/javascript">

function clickPrint() {
    window.print();
}

function RefreshPage() {
    window.location = self.location;
}

function checknull(check) {
    if (check == null)
        return "--";
    else
        return check;
}

//get วัน ใน1 เดือน
var getDaysInMonth = function(month,year) {
 return new Date(year, month, 0).getDate();
};

//แปลง ทศนิยม
function formatMoney(amount, decimalCount) {
    try {
        decimal = ".", thousands = ",";
        decimalCount = Math.abs(decimalCount);
        decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

        const negativeSign = amount < 0 ? "-" : "";

        let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
        let j = (i.length > 3) ? i.length % 3 : 0;

        return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" +
            thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
    } catch (e) {
        console.log(e)
    }
};

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}
function focus_input(id) {
   id.focus();  // or whatever you want to do
   
}

function convertDateTH(inputFormat) {
  function pad(s) { return (s < 10) ? '0' + s : s; }
  var d = new Date(inputFormat)
  return [pad(d.getMonth()+1),pad(d.getDate()), d.getFullYear()].join('/')
}

</script>

<?php 

function formatDateTH($date) {
    echo substr($date,8).'/'.substr($date,5,2).'/'.substr($date,0,4);
  }

?>