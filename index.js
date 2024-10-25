let branches_div = document.getElementById("branches");
let b = ["CHM", "AE", "BSBE", "CHE", "CE", "CSE", "ES", "ECO", "EE", "MSE", "MTH", "ME", "PHY", "SDS"];
b.sort()
for (let str of b){
    let element = document.createElement("option");
    element.innerText = str;
    element.id = str;
    branches_div.append(element);
}

let sem_div = document.getElementById("sem");
let sems = ["FIRST", "SECOND", "THIRD", "FOURTH", "FIFTH", "SIXTH", "SEVENTH", "EIGHTH"];
for (let str of sems){
    let element = document.createElement("option");
    element.innerText = str;
    element.id = str;
    sem_div.append(element);
}