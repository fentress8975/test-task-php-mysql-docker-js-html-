class ProductsTableHandler {
    constructor() {
        this.currentPage = 1;
        this.itemsPerPage = 15;
        this.pages = 0;
        this.paginateElement = document.getElementById("paginate");
        this.itemsPerPageElement = document.getElementById("itemsPerPage");

        this.theadElement = document.getElementById("thead");
        this.tbodyElement = document.getElementById("tbody");
    }

    init() {
        this.setDefaultSorterRow();
        this.setDefaultPages();
    }

    setDefaultSorterRow() {
        this.sortedRow = () => {
            for (const th of this.theadElement.firstElementChild.children) {
                if (th.classList.contains("sorted") && th.classList.contains("ASC")) return th.firstElementChild.innerHTML;
            }
        }
        this.sortedRowOrder = "ASC";
    }

    setDefaultPages() {
        this.pages = parseInt(this.paginateElement.lastElementChild.previousElementSibling.textContent.trim());
    }

    setItemsPerPage(obj) {
        const parentElement = obj.parentElement;
        for (const child of parentElement.children) {
            if (obj === child) {
                child.classList.add("active")
            }
            else {
                child.classList.remove("active")
            }
        }

        this.resetClassData();
        this.itemsPerPage = parseInt(obj.textContent.trim());
        this.getTable();
    }

    setSortRow(obj) {
        alert(`Сортируем ${obj.innerHTML} в порядке ${this.sortedRowOrder}`)
    }

    async changeQuantity(obj, i) {
        alert(`Прибавили/убавили ${obj.parentElement.parentElement.firstElementChild.innerHTML} на ${i}`)
        const myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        const response = await fetch("http://localhost/updateProductQuanity", {
            method: "POST",
            body: JSON.stringify({
                id: obj.parentElement.parentElement.firstElementChild.innerHTML,
                quanity: i,
            }),
            headers: myHeaders,
        });
        if (response.ok) {
            this.getTable();
        }
    }

    async setDelete(obj) {
        alert(`Скрыли ${obj.parentElement.parentElement.firstElementChild.innerHTML}`);
        const myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        const response = await fetch("http://localhost/setProductDeletion", {
            method: "POST",
            body: JSON.stringify({
                id: "1",
            }),
            headers: myHeaders,
        });
        if (response.ok) {
            this.resetClassData();
            this.getTable();
        }
    }

    turnPage(i) {
        this.setPage(this.currentPage + i);
    }

    setPage(i) {
        if (i !== this.currentPage && (i <= this.pages && i > 0)) {
            this.currentPage = i;
            this.getTable();
        }
    }

    async getTable() {
        //$sortRow, $sortRowOrder, $itemPerPage, $page    
        const response = await fetch("http://localhost/getTable/?" + new URLSearchParams({
            sortRow: this.sortedRow(),
            sortRowOrder: this.sortedRowOrder,
            itemPerPage: this.itemsPerPage,
            page: this.currentPage,
        }).toString());
        const data = await response.json()
        this.pages = data.pages;
        this.generateTable(data);
    }

    clearAll() {
        this.clearTable();
        this.clearPagination();
    }

    clearTable() {
        while (this.tbodyElement.firstChild) {
            this.tbodyElement.removeChild(this.tbodyElement.firstChild);
        }
    }

    clearPagination() {
        while (this.paginateElement.firstChild) {
            this.paginateElement.removeChild(this.paginateElement.firstChild);
        }
    }

    resetClassData() {
        this.currentPage = 1;
        this.itemsPerPage = 15;
        this.pages = 0;
    }

    generatePagination(pages) {
        const parent = this.paginateElement;
        const btnTurnPageMinus = document.createElement('button');
        btnTurnPageMinus.setAttribute("onclick", "productsTableHandler.turnPage(-1)");
        btnTurnPageMinus.textContent = "<";
        parent.appendChild(btnTurnPageMinus);
        for (let i = 0; i < pages; i++) {
            const btn = document.createElement('button');
            btn.setAttribute("onclick", `productsTableHandler.setPage(${i + 1})`);
            btn.textContent = i + 1;
            parent.appendChild(btn);
        }
        const btnTurnPagePlus = document.createElement('button');
        btnTurnPagePlus.setAttribute("onclick", "productsTableHandler.turnPage(+1)");
        btnTurnPagePlus.textContent = ">";
        parent.appendChild(btnTurnPagePlus);
    }

    generateTable(data) {
        this.clearAll();

        for (const products of data.table) {
            const tr = document.createElement('tr');
            tr.id = (products["ID"]);
            for (const key in products) {
                if (Object.prototype.hasOwnProperty.call(products, key)) {
                    const element = products[key];
                    if (key === "ID") continue;
                    const td = document.createElement('td');
                    if (key === "PRODUCT_DELETED") {
                        const btn = document.createElement('button');
                        btn.setAttribute("onclick", "productsTableHandler.setDelete(this)");
                        btn.textContent = "×";
                        td.appendChild(btn);
                    }
                    else if (key === "PRODUCT_QUANTITY") {
                        const btnMinus = document.createElement('button');
                        btnMinus.setAttribute("onclick", "productsTableHandler.changeQuantity(this,-1)");
                        btnMinus.textContent = "−";
                        td.appendChild(btnMinus);

                        const span = document.createElement('span');
                        span.textContent = " " + element + " ";
                        td.appendChild(span);

                        const btnPlus = document.createElement('button');
                        btnPlus.setAttribute("onclick", "productsTableHandler.changeQuantity(this,+1)");
                        btnPlus.textContent = "+";
                        td.appendChild(btnPlus);
                    }
                    else {
                        td.textContent = element;
                    }
                    tr.appendChild(td)
                }
            }
            tbody.appendChild(tr);
        }
        this.generatePagination(data.pages);
    }

}

const productsTableHandler = new ProductsTableHandler();
productsTableHandler.init();