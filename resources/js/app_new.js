// console.log('jfhdskjfhdsjkghdfjkh')

window.addEventListener('scroll', function () {
  document.getElementById('header-nav').classList.toggle('headernav-scroll', window.scrollY > 135);
});

// відкриття та закриття вікна приймання картриджів
// 13:55 Адаптивная верстка интернет-магазина на Bootstrap 5. Урок 9.mp4
const offcanvasCartEl = document.getElementById('offcanvasCart');
const offcanvasCart = new bootstrap.Offcanvas(offcanvasCartEl);

document.getElementById('package-open').addEventListener('click', (e) => {
  e.preventDefault();
  offcanvasCart.toggle();
});

document.querySelectorAll('.closecart').forEach(item => {
  item.addEventListener('click', (e) => {
    e.preventDefault();
    offcanvasCart.hide();
    let href = item.dataset.href;
    document.getElementById(href).scrollIntoView();
  });
});
// ./відкриття та закриття вікна приймання картриджів

// кнопка повернення на початок при скроле
let calcScrollValue = () => {
  let scrollProgress = document.getElementById("progress");
  let progressValue = document.getElementById("progress-value");
  let pos = document.documentElement.scrollTop;
  let calcHeight =
    document.documentElement.scrollHeight -
    document.documentElement.clientHeight;
  let scrollValue = Math.round((pos * 100) / calcHeight);
  if (pos > 100) {
    scrollProgress.style.display = "grid";
  } else {
    scrollProgress.style.display = "none";
  }
  scrollProgress.addEventListener("click", () => {
    document.documentElement.scrollTop = 0;
  });
  scrollProgress.style.background = `conic-gradient(#ffd333 ${scrollValue}%, #e2e3e5 ${scrollValue}%)`;
};
window.onscroll = calcScrollValue;
window.onload = calcScrollValue;
// ./кнопка повернення на початок при скроле
if (document.querySelector('.slider-main')) { }


window.onload = function () {
  // відслідковую подію по натисканню
  document.addEventListener("click", documentActions);
  function documentActions(e) {
    const targetElement = e.target;
    // клик на круглу кнопку покласти в пакет
    if (targetElement.classList.contains('action-device__button')) {
      alert('action-device__button');
      const deviceId = targetElement.closest('.item-device').dataset.pid;
      addToCart(targetElement, deviceId);
      e.preventDefault();
    }

  }
}

// кладемо в пакет Device
function addToCart(deviceButton, deviceId){
    // перевірка на наявність в class атрибута _hold, та додавання
    if (!deviceButton.classList.contains('_hold')){
      deviceButton.classList.add('_hold');
      deviceButton.classList.add('_fly');

      const cart=document.querySelector('.cart-header__icon');
      const device=document.querySelector(`[data-pid="${deviceId}"]`);
      // const deviceImage=device.querySelector('.item-device__svg');
      // const deviceImage=device.querySelector('.action-device__button');
      const deviceImage=device.querySelector('.devices__item');

      // створення клона зображення пакетика
      const deviceImageFly=deviceImage.cloneNode(true);

      // визначаємо розмір та координати клона
      const deviceImageFlyWidth = deviceImage.offsetWidth;
      const deviceImageFlyHeight = deviceImage.offsetHeight;
      const deviceImageFlyLeft = deviceImage.getBoundingClientRect().left;
      const deviceImageFlyTop = deviceImage.getBoundingClientRect().top;

      deviceImageFly.setAttribute('class', '_flyImage _ibg');
      deviceImageFly.style.cssText =
      `
      left: ${deviceImageFlyLeft}px;
      top: ${deviceImageFlyTop}px;
      width: ${deviceImageFlyWidth}px;
      height: ${deviceImageFlyHeight}px;
      fill: red;
      `;

      // додаємо клон (додається в кінець body) 
      document.body.append(deviceImageFly);

      const cartFlyLeft = cart.getBoundingClientRect().left;
      const cartFlyTop = cart.getBoundingClientRect().top;

      deviceImageFly.style.cssText =
      `
      left: ${cartFlyLeft}px;
      top: ${cartFlyTop}px;
      width: 20px;
      height: 20px;
      opacity:0;
      `;

      deviceImageFly.addEventListener('transitionend', function(){
        if (deviceButton.classList.contains('_fly')){
          // видалення клона зображення пакетика
          deviceImageFly.remove();
          updateCart(deviceButton, deviceId);
          deviceButton.classList.remove('_fly');
        }
      });
    }

}

function updateCart(deviceButton, deviceId, deviceAdd = true){
  const cart = document.querySelector('.cart-header');
  const cartIcon = cart.querySelector('.cart-header__icon');
  const cartQuantity = cartIcon.querySelector('span');
  const cartDevice = document.querySelector(`[data-cart-pid="${deviceId}"]`);
  const cartList = document.querySelector('.cart-list');

  // додаємо device
  if (deviceAdd) {
    if (cartQuantity){
      cartQuantity.innerHTML=++cartQuantity.innerHTML;
    }else{
      cartIcon.insertAdjacentHTML('beforeend', `<span class="badge text-bg-warning cart-badge bg-warning rounded-circle">1</span>`);
      // 3:48
    }

    if(!cartDevice){
      const device = document.querySelector(`[data-cart-pid="${deviceId}"]`); 
      const cartDeviceName = document.querySelector('.item-device__name').innerHTML; 
      const cartDeviceDevtype = document.querySelector('.item-device__devtype').innerHTML; 
      const cartDeviceContent = `
      <div class="cart-list__body">
      <p> ${cartDeviceDevtype}</p>
      <p> ${cartDeviceName}</p>
      <div class="cart-list__quantity">К-сть: <span>1</span></div>
      <a href="" class="cart-list__delete">Видалити</a>
      </div>`;
      cartList.insertAdjacentHTML('beforeend',`<li datacart-pid="${deviceId}" class="cart-list__item">${cartDeviceContent}</li>`);
    }else{
      const cartDeviceQuantity = cartDevice.querySelector('.cart-list__quantity span');
      cartDeviceQuantity.innerHTML = ++cartDeviceQuantity;
    }

    // прибираємо класс _hold
    deviceButton.classList.remove('_hold');
  }

}


// import '../css/app.css';
// import '../css/trix.css'; вантажиться css

// import viteConfig from "../../vite.config";

// прописан в vite.config.js
// @ => 'resources/js'
// Виклик JS з папки component
// import '@/Title.js'







// Полный курс Laravel 10 _ Компоненты + Вёрстка.mp4
//import './components/trix.js';

// Прописуємо щоб картинки переносились до папки public/build
// import.meta.glob(['../img/**']);
