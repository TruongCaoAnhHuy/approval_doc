const $ = document.querySelector.bind(document);
const $$ = document.querySelectorAll.bind(document);

const url = new URL(window.location.href);
const urlParams = new URLSearchParams(window.location.search);

// change page inbox, outbox 
const menuItems = $$('.menu_item');
menuItems?.forEach(menuItem => {
    menuItem.onclick = (e) => {
        if(e.target.localName === "a") {
            $('.menu_item.menu_item--active').classList.remove('menu_item--active')
            e.target.parentElement.classList.add('menu_item--active')
        } else {
            $('.menu_item.menu_item--active').classList.remove('menu_item--active')
            e.target.classList.add('menu_item--active')
        }
    }
})

// const inboxBtn = $('#Inbox')
// inboxBtn.onclick = (e) => {
//     if(url.search) {
        
//         window.location.search = urlParams.toString() + `?item=${e.target.id}`;
//     } else if(!url.search) {
//         window.location.search = urlParams.toString() + `?item=${e.target.id}`;
//     }
// }

const itemTag = $(`#${urlParams.get('item')}`)
itemTag ? itemTag.classList.add('menu_item--active') : $(`#Inbox`).classList.add('menu_item--active');

// trim input
const inputs= $$('.input-value');
inputs.forEach(input => {
    const inputValue = input.value;
    const trimInputValue = inputValue.trim()
    input.value = trimInputValue;
});

// trim textarea
const textareas= $$('.textarea-value');
textareas.forEach(textarea => {
    const textareaValue = textarea.value;
    const trimTextareaValue = textareaValue.trim()
    textarea.value = trimTextareaValue;
});

// format date modal
const inputDates = $$('.input-value_date');
inputDates.forEach(inputDate => {
    var inputDateValue = inputDate.value;
    var formattedDate = formatDate(inputDateValue);
    inputDate.value = formattedDate;
})

// sort
const sortBtns = $$('.sort');
const sortActioning = document.getElementById(urlParams.get('sort')?.slice(0, 6));
sortActioning?.classList.add('sort--active');

sortBtns.forEach(sortBtn => {

    sortBtn.onclick = (e) => {
            // window.location.search = urlParams.toString() + `?filter=${e.target.id}asc`;
        let sortAction = "asc"       
        
        if(!url.search){
            window.location.search = urlParams.toString() + `?sort=${e.target.id}${sortAction}`;
            if(urlParams.has('sort')) {

                if(e.target.id === urlParams.get('sort').slice(0, -3)) {
                    sortAction = "desc"
                    urlParams.delete('sort');
                    window.location.search = urlParams.toString() + `?sort=${e.target.id}${sortAction}`;
                } else {
                    urlParams.delete('sort');
                    window.location.search = urlParams.toString() + `?sort=${e.target.id}${sortAction}`;
                }
            }
        } else if(url.search) {
            if(urlParams.has('sort') || urlParams.has('page') || urlParams.has('inbox')) {
                if(urlParams.has('sort') && e.target.id === urlParams.get('sort').slice(0, -3)) {
                    sortAction = "desc"
                    urlParams.delete('sort');
                    window.location.search = urlParams.toString() + `&sort=${e.target.id}${sortAction}`;
                } else {
                    urlParams.delete('sort');
                    urlParams.delete('page');
                    urlParams.delete('inbox');
                    window.location.search = urlParams.toString() + `&sort=${e.target.id}${sortAction}`;
                }
            } else {
                window.location.search = urlParams.toString() + `&sort=${e.target.id}${sortAction}`;
            }
        }   
    }
})

// value input_finding 
const inputFinding1 = document.getElementsByName('_1')[0].value = urlParams.get('_1');
const inputFinding2 = document.getElementsByName('_2')[0].value = urlParams.get('_2');
const inputFinding3 = document.getElementsByName('_3')[0].value = urlParams.get('_3');
const inputFinding4 = document.getElementsByName('_4')[0].value = urlParams.get('_4');
const inputFinding5 = document.getElementsByName('_5')[0].value = urlParams.get('_5');
const inputFinding6 = document.getElementsByName('_6')[0].value = urlParams.get('_6');
const inputFinding7 = document.getElementsByName('_7')[0].value = urlParams.get('_7');
const inputFinding8 = document.getElementsByName('_8')[0].value = urlParams.get('_8');

// change active link page
const paramPage = urlParams.get('page') ? urlParams.get('page') : 1; // Kết quả: 'value1'
const pageNums = $$('.page_num');
pageNums[Number(paramPage) - 1]?.classList.add('page_num--active');
pageNums.forEach(pageNum => {
    pageNum.onclick = (e) => {
        if(e.target.localName === "a") {
            $('.page_num.page_num--active').classList.remove('page_num--active')
            e.target.classList.add('page_num--active')
        }

        if(!url.search){
            if(urlParams.has('page')) {
                urlParams.delete('page');
                window.location.search = urlParams.toString() + `?page=${e.target.innerText}`;
            } else if(urlParams.has('inbox')) {
                urlParams.delete('inbox');
                window.location.search = urlParams.toString() + `?page=${e.target.innerText}`;
            } else {
                window.location.search = urlParams.toString() + `?page=${e.target.innerText}`;
            }
        } else if(url.search) {
            if(urlParams.has('page') || urlParams.has('inbox')) {
                urlParams.delete('page');
                urlParams.delete('inbox');
                window.location.search = urlParams.toString() + `&page=${e.target.innerText}`;
            } else {
                window.location.search = urlParams.toString() + `&page=${e.target.innerText}`;
            }
        } 
    }
})

// next btn & prev btn
const paramPageNum = Number(urlParams.get('page'))
const pageLength = $$('.page_num').length;
// next
const nextBtn = $('#next_page-btn');
if(paramPageNum === pageLength) {
    nextBtn.classList.add('disabled')
}
nextBtn.onclick = () => {
    let paramChange;
    if(!urlParams.get('page')) {
        paramChange = 2;
    } else {
        paramChange = paramPageNum + 1
    }
    
    if(!url.search){
        if(urlParams.has('page')) {
            urlParams.delete('page');
            window.location.search = urlParams.toString() + `?page=${paramChange}`;
        } else if(urlParams.has('inbox')) {
            urlParams.delete('inbox');
            window.location.search = urlParams.toString() + `?page=${paramChange}`;
        } else {
            window.location.search = urlParams.toString() + `?page=${paramChange}`;
        }
    } else if(url.search) {
        if(urlParams.has('page') || urlParams.has('inbox')) {
            urlParams.delete('page');
            urlParams.delete('inbox');
            window.location.search = urlParams.toString() + `&page=${paramChange}`;
        } else {
            window.location.search = urlParams.toString() + `&page=${paramChange}`;
        }
    } 
}

// prev
const prevBtn = $('#prev_page-btn');
if(paramPageNum === 1 || !urlParams.get('page')) {
    prevBtn.classList.add('disabled')
}
prevBtn.onclick = () => {
    let paramChange = paramPageNum - 1

    if(!url.search){
        if(urlParams.has('page')) {
            urlParams.delete('page');
            window.location.search = urlParams.toString() + `?page=${paramChange}`;
        } else if(urlParams.has('inbox')) {
            urlParams.delete('inbox');
            window.location.search = urlParams.toString() + `?page=${paramChange}`;
        } else {
            window.location.search = urlParams.toString() + `?page=${paramChange}`;
        }
    } else if(url.search) {
        if(urlParams.has('page') || urlParams.has('inbox')) {
            urlParams.delete('page');
            urlParams.delete('inbox');
            window.location.search = urlParams.toString() + `&page=${paramChange}`;
        } else {
            window.location.search = urlParams.toString() + `&page=${paramChange}`;
        }
    } 
}

// select page
const selectPage = $('.select_page');
selectPage.value = paramPageNum ? paramPageNum : 1
selectPage.onchange = (e) => {
    if(!url.search){
        if(urlParams.has('page')) {
            urlParams.delete('page');
            window.location.search = urlParams.toString() + `?page=${e.target.value}`;
        } else if(urlParams.has('inbox')) {
            urlParams.delete('inbox');
            window.location.search = urlParams.toString() + `?page=${e.target.value}`;
        } else {
            window.location.search = urlParams.toString() + `?page=${e.target.value}`;
        }
    } else if(url.search) {
        if(urlParams.has('page') || urlParams.has('inbox')) {
            urlParams.delete('page');
            urlParams.delete('inbox');
            window.location.search = urlParams.toString() + `&page=${e.target.value}`;
        } else {
            window.location.search = urlParams.toString() + `&page=${e.target.value}`;
        }
    } 
}

function showModal() {
    const modal = $('.modal');
    const closeModalBtn = $('.modal-close')
    modal.classList.add('show')

    modal.onclick = (e) => {
        e.target.classList.remove('show')
    }

    closeModalBtn.onclick = () => {
        $('.modal.show').classList.remove('show')
    }
}

function getQueryParamValue(paramName) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(paramName);
}

function checkInboxParamAndShowModal() {
    const inboxParam = getQueryParamValue('inbox');
    if (inboxParam) {
        showModal();
    }
}

// Kiểm tra tham số 'inbox' khi trang web tải lại
window.addEventListener('load', checkInboxParamAndShowModal);

// Kiểm tra tham số 'inbox' khi URL thay đổi (không làm trang web tải lại)
window.addEventListener('popstate', checkInboxParamAndShowModal)

// function format date modal
function formatDate(inputDate) {
    var date = new Date(inputDate);
    
    if (isNaN(date)) {
      // Kiểm tra nếu đầu vào không hợp lệ
      return "00/00/0000";
    }

    var day = date.getDate();
    var month = date.getMonth() + 1;
    var year = date.getFullYear();
  
    // Định dạng lại thành dd/mm/yyyy
    var formattedDate = (day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + year;
    return formattedDate;
}

// resize info modal
const resizeBtn = $('.show-info-btn');
const formModal = $('.modal-form');
const showInfoBtn = $('.icon_show-info');
showInfoBtn.classList.add('glyphicon-chevron-down')

resizeBtn.onclick = () => {
    formModal.classList.toggle('modal-form--show')
    if(showInfoBtn.classList[2] === 'glyphicon-chevron-down') {
        showInfoBtn.classList.remove('glyphicon-chevron-down');
        showInfoBtn.classList.add('glyphicon-chevron-up');
    } else {
        showInfoBtn.classList.remove('glyphicon-chevron-up');
        showInfoBtn.classList.add('glyphicon-chevron-down');
    }
}