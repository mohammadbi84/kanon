$(document).on("input", ".only-number", function () {
    this.value = this.value.replace(/[^0-9]/g, "");
    let name = $(this).attr("name");
    const box = document.getElementById("autocompleteBox" + name);
    const clearBtn = document.getElementById("clearBtn_" + name);
    let value2 = $(this).val();
    if (value2.length > 0) {
        box.classList.add("filled");
        clearBtn.style.display = "block";
    } else {
        box.classList.remove("filled");
        clearBtn.style.display = "none";
    }
});

function nameinput(id) {
    const input = document.getElementById("searchInput" + id);
    const box = document.getElementById("autocompleteBox" + id);
    const clearBtn = document.getElementById("clearBtn_" + id);
    if (input.value.length > 0) {
        box.classList.add("filled");
        clearBtn.style.display = "block";
    } else {
        box.classList.remove("filled");
        clearBtn.style.display = "none";
    }
}

function clearInput(id) {
    const box = document.getElementById("autocompleteBox" + id);
    box.classList.remove("filled");
    const input = document.getElementById("searchInput" + id);
    input.value = "";
    const clearBtn = document.getElementById("clearBtn_" + id);
    clearBtn.style.display = "none";

    if (id == "state") {
        const box2 = document.getElementById("autocompleteBoxcity");
        const input2 = document.getElementById("searchInputcity");
        input2.value = "";
        document.getElementById("selectedIdcity").value = "";
        box2.classList.remove("filled");
        const clearBtn2 = document.getElementById("clearBtn_city");
        clearBtn2.style.display = "none";
    }
}
