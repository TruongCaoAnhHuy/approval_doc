Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});

const currentDate = new Date();
const currentYear = currentDate.getFullYear();

document.getElementById('input-date') ? document.getElementById('input-date').value = new Date().toDateInputValue() : ''
document.getElementById('date_value') ? document.getElementById('date_value').innerText = ConvertDate(new Date().toDateInputValue()) : ''
document.getElementById('year') ? document.getElementById('year').innerText = `Year: ${currentYear}` : ''

function ConvertDate(dateStr) {
    // Chuyển đổi ngày từ chuỗi "yyyy-mm-dd" thành đối tượng Date
    const date = new Date(dateStr);

    // Kiểm tra xem ngày có hợp lệ không
    if (isNaN(date)) {
        return "Ngày không hợp lệ";
    }

    // Lấy ngày, tháng và năm từ đối tượng Date
    const day = date.getDate();
    const month = date.getMonth() + 1; // Tháng trong JavaScript bắt đầu từ 0
    const year = date.getFullYear();

    // Định dạng lại thành "dd-mm-yyyy"
    const convertDate = `${day.toString().padStart(2, '0')}/${month.toString().padStart(2, '0')}/${year}`;

    return convertDate;
}