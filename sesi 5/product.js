const products = [
    {
        id: 1,
        name: "Laptop Lenovo LOQ",
        description: "Laptop performa tinggi untuk gaming dan editing.",
        price: 15000000,
        category: "Elektronik",
        image: "https://www.jagatreview.com/wp-content/uploads/2023/07/Lenovo-LOQ-15IRH8-1.png"
    },
    {
        id: 2,
        name: "HP Gaming ASUS ROG Phone 9",
        description: "Smartphone dengan kamera jernih dan baterai tahan lama.",
        price: 5000000,
        category: "Elektronik",
        image: "https://asset.kompas.com/crops/-FoCP-4CgyPjhD6qlkUIdvBoMGI=/151x36:1784x1125/1200x800/data/photo/2024/11/20/673d2f1f13aca.jpg"
    },
    {
        id: 3,
        name: "Sepatu Running NIKE AIR",
        description: "Sepatu nyaman untuk olahraga.",
        price: 750000,
        category: "Fashion",
        image: "https://images.tokopedia.net/img/cache/700/VqbcmM/2023/2/15/d29014ce-2492-4689-88f2-fec1414e66f1.jpg.webp"
    },
    {
        id: 4,
        name: "Kursi Gaming Secretlab TITAN EVO",
        description: "Kursi terbaik dan nyaman.",
        price: 8500000,
        category: "Furniture",
        image: "https://seremonia.id/wp-content/uploads/2023/03/SL_TitanEvoR_Cyberpunk0001S.png"
    },
    {
        id: 5,
        name: "Jam Tangan",
        description: "Jam tangan stylish dan elegan.",
        price: 1200000,
        category: "Fashion",
        image: "https://omniluxe.id/cdn/shop/files/Richard-Mille-RM-030-Rosegold-Titanium-_1_1200x.jpg?v=1748338226"
    }
];

const productContainer = document.getElementById("productContainer");
const template = document.getElementById("productTemplate");
const searchInput = document.getElementById("searchInput");
const categoryFilter = document.getElementById("categoryFilter");
const priceSort = document.getElementById("priceSort");

function formatRupiah(number) {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR"
    }).format(number);
}

function renderProducts(data) {
    productContainer.innerHTML = "";

    if (data.length === 0) {
        productContainer.innerHTML = "<p class='text-center'>Produk tidak ditemukan</p>";
        return;
    }

    // 🔥 Looping ada di sini menggunakan template HTML
    data.forEach(product => {
        const clone = template.content.cloneNode(true);

        clone.querySelector(".product-image").src = product.image;
        clone.querySelector(".product-name").textContent = product.name;
        clone.querySelector(".product-category").textContent = product.category;
        clone.querySelector(".product-description").textContent = product.description;
        clone.querySelector(".product-price").textContent = formatRupiah(product.price);

        productContainer.appendChild(clone);
    });
}

function populateCategories() {
    const categories = [...new Set(products.map(p => p.category))];
    categories.forEach(category => {
        const option = document.createElement("option");
        option.value = category;
        option.textContent = category;
        categoryFilter.appendChild(option);
    });
}

function filterProducts() {
    let filtered = [...products];

    const searchValue = searchInput.value.toLowerCase();
    const categoryValue = categoryFilter.value;
    const sortValue = priceSort.value;

    if (searchValue) {
        filtered = filtered.filter(p =>
            p.name.toLowerCase().includes(searchValue)
        );
    }

    if (categoryValue) {
        filtered = filtered.filter(p =>
            p.category === categoryValue
        );
    }

    if (sortValue === "low") {
        filtered.sort((a, b) => a.price - b.price);
    } else if (sortValue === "high") {
        filtered.sort((a, b) => b.price - a.price);
    }

    renderProducts(filtered);
}

searchInput.addEventListener("input", filterProducts);
categoryFilter.addEventListener("change", filterProducts);
priceSort.addEventListener("change", filterProducts);

populateCategories();
renderProducts(products);
