async function testPost() {
    const myHeaders = new Headers();
    myHeaders.append("Content-Type", "application/json");

    const response = await fetch("http://localhost/updateProductQuanity", {
        method: "POST",
        body: JSON.stringify({
            id: "1",
            quanity: "5"
        }),
        headers: myHeaders,
    });

    console.log(response.ok);
}

// def value

class ProductsTableHandler {
    constructor() {
        this.currentPage = 1;
        this.offset = 0;
        this.itemsPerPage = 15;
        this.paginateElement = document.getElementById("paginate");
        this.itemsPerPageElement = document.getElementById("itemsPerPage");

        this.theadElement = document.getElementById("thead");
    }

    init() {
        this.setDefaultSorterRow();
    }

    setDefaultSorterRow() {
        this.sortedRow = () => {
            for (const th of this.theadElement.firstElementChild.children) {
                if (th.classList.contains("sorted") && th.classList.contains("ASC")) return th;
            }
        }
        console.log(this.sortedRow());
        this.sortedRowOrder = "ASC";
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

        this.itemsPerPage = obj.innerHTML;
    }

    setSortRow(obj){
        alert(`Сортируем ${obj.innerHTML} в порядке ${this.sortedRowOrder}`)
    }

    changeQuantity(obj,i){
        alert(`Прибавили/убавили ${obj.parentElement.parentElement.firstElementChild.innerHTML} на ${i}`)
    }

    setDelete(obj){
        alert(`Скрыли ${obj.parentElement.parentElement.firstElementChild.innerHTML}`)

        
    }

    turnPage(i){
        alert(`Страница сдвинута на ${i}`)
    }


    generateTable(){

    }
}

const productsTableHandler = new ProductsTableHandler();
productsTableHandler.init();