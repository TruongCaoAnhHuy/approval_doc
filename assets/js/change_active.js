// change active row
const rows = $$('.row-item')
rows[0].classList.add('row-active');
rows.forEach(row=> {
    row.onclick = (e) => {
        if(e.target.localName === "td") {
            $('.row-item.row-active').classList.remove('row-active')
            e.target.parentElement.classList.add('row-active')
        } else {
            $('.row-item.row-active').classList.remove('row-active')
            e.target.classList.add('row-active')
        }
    }

    row.ondblclick = (e) => {
        if(e.target.localName === "td") {
            if(!url.search) {
                window.location.href = location.href + `?inbox=${e.target.parentElement.id}`;
            } else if(url.search) {
                if(urlParams.has('inbox')) {
                    urlParams.delete('inbox');
                    window.location.search = urlParams.toString() + `&inbox=${e.target.parentElement.id}`;
                } else {
                    window.location.search = urlParams.toString() + `&inbox=${e.target.parentElement.id}`;
                }
            }
        }
    }
});

// change active detail row
const detailRows = $$('.detail-item')
if(detailRows) {
    detailRows[0]?.classList.add('detail-item--active');
    detailRows?.forEach(row=> {
        row.onclick = (e) => {
            if(e.target.localName === "td") {
                $('.detail-item--active').classList.remove('detail-item--active')
                e.target.parentElement.classList.add('detail-item--active')
            } else {
                $('.detail-item--active').classList.remove('detail-item--active')
                e.target.classList.add('detail-item--active')
            }
        }
    });
}