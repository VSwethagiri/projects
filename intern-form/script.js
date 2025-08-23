let currentTab=0;
showTab(currentTab);

function showTab(n){
    const x=document.getElementsByClassName("tab");
    x[n].style.display = "block";

    document.getElementById("prevbtn").style.display = n ==0 ? "none": "inline";
    document.getElementById("nextbtn").innerHTML = n ==(x.length-1)?"submit" :"next";

}

function nextprev(n){
    const x = document.getElementsByClassName("tab");
    x[currentTab].style.display="none";
    currentTab = currentTab + n;

    if (currentTab >= x.length){
        document.getElementById("regform").submit();
        return false;
    }
    showTab(currentTab);
}

document.getElementById("nextbtn").onclick = ()=>nextprev(1);
document.getElementById("prevbtn").onclick = ()=>nextprev(-1);