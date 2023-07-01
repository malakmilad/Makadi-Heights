let select_zones = document.getElementById("inputZone");
let select_value = select_zones.hasAttribute("zone-value")
    ? select_zones.getAttribute("zone-value")
    : "";

let select_building_types = document.getElementById("inputBuildingType");
let select_building_type_value = select_building_types.hasAttribute(
    "building-type-value"
)
    ? select_building_types.getAttribute("building-type-value")
    : "";

let select_units = document.getElementById("inputUnit");
// let select_units_value = select_units.hasAttribute("unit-value")
//     ? select_units.getAttribute("unit-value")
//     : "";

// let unit_id_input = document.getElementById("inputUnitId");
let building_type_id_input = document.getElementById("inputBuildingTypeId");

var inputPhoneNumber = document.querySelector("#inputPhoneNumber");
window.intlTelInput(inputPhoneNumber, {
    preferredCountries: ["eg", "us", "in", "de"],
    utilsScript:
        "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
});

const loader = document.getElementById("loader-select");
const zones = [{}];
let zone = [];
const used_building_types = [];

const getZones = () => {
    fetch("https://admin.makadiheights.com/zones")
        .then((res) => res.json())
        .then((data) => {
            for (let index = 0; index < data.length; index++) {
                zones[index] = {};
                zones[index].zoneName = data[index].zoneName;
                zones[index].building_types = data[index].building_types;
                zones[index].units = data[index].units;

                var opt = document.createElement("option");
                opt.value = zones[index].zoneName;
                if (opt.value == select_value) {
                    opt.selected = true;
                }
                opt.innerHTML = zones[index].zoneName;
                select_zones.appendChild(opt);
            }
        })
        .then(() => {
            loader.style.display = "none";
            getBuildingTypes(zones);
            // getUnits(getZone());
            select_building_types.hasAttribute("cannot_be_changed")
                ? (select_building_types.disabled = true)
                : (select_building_types.disabled = false);
            if (select_zones.value) {
                getBuildingType();
            }
        });

    return zones;
};

const getZone = () => {
    const zone_filtered = zones.filter(
        (zone) => zone.zoneName == select_zones.value
    );
    return zone_filtered;
};

function getBuildingTypes(zones) {
    const building_types = zones.filter(
        (zone) => zone.zoneName == select_zones.value
    );
    const building_types_array = building_types[0].building_types;
    while (select_building_types.options.length > 0) {
        select_building_types.remove(0);
    }
    building_types[0].building_types.map((type) => {
        var opt = document.createElement("option");
        opt.value = type.unitName;
        if (opt.value == select_building_type_value) {
            opt.selected = true;
        }
        opt.innerHTML = type.unitName;
        select_building_types.appendChild(opt);
    });
    used_building_types.push(building_types_array);
    // getUnits(getZone());
    // select_units.disabled = false;
}

const getBuildingType = () => {
    const zone = getZone();

    const building_type_filtered = zone[0].building_types.filter(
        (type) => type.unitName == select_building_types.value
    );
    building_type_id_input.value = building_type_filtered[0].id;
    return building_type_filtered;
};

// function getUnits(zone) {
//     const building_type = getBuildingType();

//     const unit_filtered = zone[0].units.filter(
//         (unit) => unit.building_type == building_type[0].id
//     );

//     while (select_units.options.length > 0) {
//         select_units.remove(0);
//     }
//     unit_filtered.map((unit) => {
//         var opt = document.createElement("option");
//         opt.value = unit.unitName;
//         if (opt.value == select_units_value) {
//             opt.selected = true;
//         }
//         opt.innerHTML = unit.unitName;
//         opt.setAttribute("id", unit.id);
//         select_units.appendChild(opt);
//         unit_id_input.value =
//             select_units.options[select_units.selectedIndex].getAttribute("id");
//     });
// }

(function () {
    getZones();

    if (select_zones.hasAttribute("cannot_be_changed")) {
        select_zones.disabled = true;
    }

    select_zones.onchange = function () {
        getBuildingTypes(zones);
        select_building_types.hasAttribute("cannot_be_changed")
            ? (select_building_types.disabled = true)
            : (select_building_types.disabled = false);
        getBuildingType();
    };

    select_building_types.onchange = function () {
        getBuildingType();
        const building_type_id =
            this.options[this.selectedIndex].getAttribute("id");
        // getUnits(getZone());
    };

    // select_units.onchange = function () {
    //     const unit_id = this.options[this.selectedIndex].getAttribute("id");
    //     unit_id_input.value = unit_id;
    // };
})();
