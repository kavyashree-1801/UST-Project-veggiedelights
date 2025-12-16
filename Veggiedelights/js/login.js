const pwd=document.getElementById("password");
const tooltip=document.getElementById("passwordTooltip");
const u=document.getElementById("u");
const l=document.getElementById("l");
const s=document.getElementById("s");
const len=document.getElementById("len");

pwd.addEventListener("focus",()=>tooltip.style.display="block");
pwd.addEventListener("blur",()=>tooltip.style.display="none");

pwd.addEventListener("input",()=>{
const v=pwd.value;
u.className=/[A-Z]/.test(v)?"valid":"invalid";
l.className=/[a-z]/.test(v)?"valid":"invalid";
s.className=/[!@#$%^&*]/.test(v)?"valid":"invalid";
len.className=v.length>=6?"valid":"invalid";
});

function togglePassword(){
pwd.type=pwd.type==="password"?"text":"password";
}

document.getElementById("loginForm").addEventListener("submit",async e=>{
e.preventDefault();
const email=document.getElementById("email");
const captcha=document.getElementById("captcha");
const error=document.getElementById("error");
error.textContent="";

if(!email.value||!pwd.value||!captcha.value){
error.textContent="All fields required!";
return;
}

const fd=new FormData();
fd.append("email",email.value);
fd.append("password",pwd.value);
fd.append("captcha",captcha.value);

const res=await fetch("api/logins.php",{method:"POST",body:fd,credentials:"include"});
const data=await res.json();

if(data.success){
window.location.href="index.php";
}else{
error.textContent=data.error;
}
});