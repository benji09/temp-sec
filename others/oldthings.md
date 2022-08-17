// egret 

游戏规则
5武器装备
8武器装备列表详情
答题闯关
我的收藏
闯关每关列表
答题界面




用户信息：dataManager
现成组件：按钮、右边按钮、分享，标题、进度条
设置背景 scene
获取本地数据json util
题目util

$children
宽高比Unil


删除使用 EventTarget.addEventListener() 方法添加的事件, 返回值undefined
element.removeEventListener("mousedown", handleMouseDown, false);     // 失败


定义对象：
private hAlignTexts:{[align:string]:string} = {};

代码规范：

1.注释
2.静态大写

private timer = null 
private isInit = false


.once 全局？？

统计写过的egret类： 

1. DisplayObjectContainer
    addChild

2. Shape       (创建简单形状)
 graphics   （访问各种矢量绘图方法）

3. Graphics 

4. Event        (作为创建事件实例的基类)
    添加事件传有event
    ??? event.target类型查询
    evt.currentTarget
    <egret.Shape>e.currentTarget
    evt.stopImmediatePropagation()

5. TouchEvent
6. FocusEvent


6. TextField    (文本渲染, 可能会有渲染差异如果开发者希望所有平台完全无差异，请使用BitmapText)
7. ITextElement     (用于建立多种样式混合文本的基本结构)
8. HorizontalAlign
9. HtmlTextParser
10. TextFieldType




7. ImageLoader  (加载图像（JPG、PNG 或 GIF）文件)

??? 8. Texture      (对不同平台不同的图片资源的封装在HTML5中)

9. Bitmap       (显示位图图片的显示对象)
???将已加载完成的图像显示出来 imgloader -> Bitmap 

10. BitmapData      (对象是一个包含像素数据的数组)

11. egret.log   (全局函数， http://developer.egret.com/cn/apidoc/index/name/egret.globalFunction)

12. mask 

13. Timer       (计时器的接口)
14. TimerEvent 
        event.target前有类型定义<egret.Timer>event.target




12. BitmapFillMode
13. BlendMode   (提供混合模式可视效果的常量值)

14. Sprite       (基本显示列表构造块)

15. EventDispatcher     （事件派发器类，负责进行事件的发送和侦听）

????  16. IEventDispatcher    (接口定义用于添加或删除事件侦听器的方法，检查是否已注册特定类型的事件侦听器，并调度事件)

17. HashObject      （Egret顶级对象。框架内所有对象的基类，为对象实例提供唯一的hashCode值。）

18. HttpRequest         (以文本或二进制数据的形式从 URL 下载数据)

18. HttpResponseType

19. ExternalInterface   ("外部接口"， h5与native交互)

20. Matrix      （一个转换矩阵）
21. Point       (二维坐标系统中的某个位置)
21. Rectangle   (按其位置（由它左上角的点 (x, y) 确定）以及宽度和高度定义的区域)

22. ColorMatrixFilter   (可以将 4 x 5 矩阵转换应用于输入图像上的每个像素的 RGBA 颜色和 Alpha 值)


22. stage  主绘图区



22.localStorage   (全局)

21.sound
22.video

23. ProgressEvent
24. IOErrorEvent

25. StageScaleMode

26. DeviceOrientation

27. Geolocation     (从设备的定位服务获取设备的当前位置)

28. Motion      (从用户设备读取运动状态信息并派发 CHANGE 事件)

29. Capabilities

30. text: 
    BitmapFont
    BitmapText
    HtmlTextParser
    TextField

31. lifecycle
    ByteArray
    callLater
    getDefinitionByName
    getOption
    getQualifiedClassName
    getQualifiedSuperclassName
    getTimer
    hasDefinition
    is
    NumberUtils
    Timer
    toColorString
    XML
    CustomFilter    （自定义滤镜，目前仅支持WebGL模式）

32. Tween       (动画缓动类. 字面意思“补间动画”)

32. MovieClip   (影片剪辑)
33. MovieClipData
33. MovieClipDataFactory
34. MovieClipEvent


35. assetsManager  (底层存储资源信息)
RES相关都在这里





36. 写好的LoadingUI 底层逻辑待看

37. dragonBones   目前项目中未应用

38. lifecycle
切换应用前后台


EUI部分

UILayer: 容器
Label 
UIEvent
Group 自动布局的容器基类
Scroller 显示一个称为视域的单个可滚动


// old ts version 
1.JS的超集, 微软开发，面向对象
  现有的 JavaScript 代码可与 TypeScript 一起工作无需任何修改


2.安装
// 安装失败的话请以管理员身份运行，此处是sudo命令是mac上管理员权限
sudo npm install typescript -g

3.其他命令
版本: tsc -v 
转化为JS: tsc test.ts,
执行JS: node xxx.js,
同时编译多个ts文件: tsc file1.ts file2.ts file3.ts,



4.  TS 基础类型 9个
string 
boolean
number
null    （表示对象值缺失。）
undefined 


any       （任意类型）
数组
元组       （已知元素数量和类型的数组,  let x: [string, number];）
enum       (枚举：定义数值集合, enum Color {Red, Green, Blue};)
void 
never    (是其它类型（包括 null 和 undefined）的子类型，代表从不会出现的值)



例子： 
 1. 数组类型：
// 在元素类型后面加上[]
let arr: number[] = [1, 2];
// 或者使用数组泛型
let arr: Array<number> = [1, 2];

 2. enum 枚举
enum Color {Red, Green, Blue};
let c: Color = Color.Blue;
console.log(c);    // 输出 2


 3. 元组
  let x: [string, number];
  x = ['Runoob', 1];    // 运行正常
  x = [1, 'Runoob'];    // 报错
  console.log(x[0]);    // 输出 Runoob


7. ts元组
元组中允许存储不同类型的元素，元组可以作为参数传递给函数。
var mytuple = [10,"Runoob"]; // 创建元组



9. TS接口
接口是一系列抽象方法的声明，是一些方法特征的集合
接口不能转换为 JavaScript。 它只是 TypeScript 的一部分。
interface IPerson { 
    firstName:string, 
    lastName:string, 
    sayHi: ()=>string 
} 
 
var customer:IPerson = { 
    firstName:"Tom",
    lastName:"Hanks", 
    sayHi: ():string =>{return "Hi there"} 
} 


10. TS类  
静态    (不会被实例继承)
static num:number;
static disp():void {console.log()}

类可以实现接口
用关键字implements，并将 interest 字段作为类的属性使用。


访问控制修饰符: 来保护对类、变量、方法和构造方法的访问
protected : 受保护，可以被其自身以及其子类和父类访问。

11. TS对象
  鸭子类型（Duck Typing）？

12. TS命名空间 ： 解决重名问题
  namespace SomeNameSpaceName {  //export: 可以在外部调用
   export interface ISomeInterfaceName {      }  
   export class SomeClassName {      }  
}

13. TS模块  （设计理念是可以更换的组织代码。）
格式：
    // 文件名 : SomeInterface.ts 
    export interface SomeInterface { 
      // 代码部分
    }
使用它：
  import someInterfaceRef = require("./SomeInterface");


14. TS声明文件  (.d.ts 为后缀)
语法格式： 
declare module Module_Name {
}

TypeScript 引入声明文件语法格式:
/// <reference path = " runoob.d.ts" />


15. TS数组
语法： 
var sites:string[]; 
sites = ["Google","Runoob","Taobao"]
或
var numlist:number[] = [2,4,6,8]


16. TS MAP对象  （保存键值对，并且能够记住键的原始插入顺序）
迭代(“更替”)Map （for...of）
// 迭代 Map 中的 key
for (let key of nameSiteMapping.keys()) {
    console.log(key);                  
}

17. TS元组  (如果数组存储的元素数据类型不同，则需要使用元组。允许存储不同类型的元素，元组可以作为参数传递给函数)
如：
var mytuple = [10,"Runoob"];


18. TS联合类型  (通过管道(|)将变量设置多种类型)
如：
var val:string|number 

19.TS接口  (抽象方法的声明,需要由具体的类去实现,第三方就可以通过这组抽象方法调用，让具体的类执行具体的方法)
允许接口继承多个接口
注：接口不能转换为 JavaScript。 它只是 TypeScript 的一部分。
interface IPerson {}
例：
interface IPerson { 
    firstName:string, 
    lastName:string, 
    sayHi: ()=>string 
} 
 
var customer:IPerson = { 
    firstName:"Tom",
    lastName:"Hanks", 
    sayHi: ():string =>{return "Hi there"} 
} 
 
console.log("Customer 对象 ") 
console.log(customer.firstName) 
console.log(customer.lastName) 
console.log(customer.sayHi())  


20. TS循环   
for...in 
还支持 for…of 、forEach、every 和 some 循环。
while() {}
do {}while()

21. TS函数
function greet():string { // string:返回值类型
    return "Hello World" 
} 

可选参数和默认参数: 我们定义了参数，则我们必须传入这些参数，除非将这些参数设置为可选，可选参数使用问号标识 ？
function buildName(firstName: string, lastName?: string) {}

默认参数：  （参数 rate 设置了默认值为 0.50，调用该函数时如果未传入参数则使用该默认值）
function calculate_discount(price:number,rate:number = 0.50) {}

剩余参数：   (允许我们将一个不确定数量的参数作为一个数组传入)
function buildName(firstName: string, ...restOfName: string[]) {}
let employeeName = buildName("Joseph", "Samuel", "Lucas", "MacKinzie");

匿名函数
  1.匿名函数自调用
  (function () { 
    var x = "Hello!!";   
    console.log(x)    
  })()

构造函数   (JavaScript 内置的构造函数 Function())
var res = new Function ([arg1[, arg2[, ...argN]],] functionBody)
如： 
var myFunction = new Function("a", "b", "return a * b"); 
var x = myFunction(4, 3); 
console.log(x);

递归函数   （在函数内调用函数本身）
6*5*4*3*2*1   用这个好写


Lambda 函数   （箭头函数）

函数重载   (方法名字相同，而参数不同，返回类型可以相同也可以不同)
  如果参数类型不同，则参数类型应设置为 any。
  参数数量不同你可以将不同的参数设置为可选。


22. TS Number对象
对象属性
  1. Number.MAX_VALUE
  2. Number.MIN_VALUE
  3. Number.NaN 
  4. Number.NEGATIVE_INFINITY
  5. Number.POSITIVE_INFINITY
  6. Number.prototype   ( (使有能力向对象添加属性和方法。))
  7. Number.constructor  (返回对创建此对象的 Number 函数的引用。)
对象方法
1. toExponential（）
2. toFixed（）
3. toLocaleString（）
4. toPrecision（）
5. toString（） 
6. valueOf（）

23. TS string (属性跟方法：https://www.runoob.com/typescript/ts-string.html)
var txt = new String("string");
或者更简单方式：
var txt = "string";


24. TS运算符    （https://www.runoob.com/typescript/ts-operators.html）
算术运算符
逻辑运算符
关系运算符
按位运算符:   
  >>  ： 转二进制，左移动，右位数， 高位丢弃，低位补0  5>>1 :2




赋值运算符
三元/条件运算符
字符串运算符
类型运算符


25. TS 变量声明
  类型断言（Type Assertion）:允许变量从一种类型更改为另一种类型
var str = '1' 
var str2:number = <number> <any> str   //str、str2 是 string 类型



26. 
  1. tsc 常用编译参数  (https://www.runoob.com/typescript/ts-basic-syntax.html)
  2. 分号是可选的
  3. 支持两种类型的注释 //   /*多行注释*/
  4. 面向对象   （对象和类）
  

// review es

1. 读写数组元素
        // 数组是一种特殊的对象
        let o = {};
        o[1] = 'one';   // {1: 'one'}
        o['1']  // 'one', 数值、字符串属性名是同一个，
                // 但只有介于0和2^32-2之间的整数属性名才是索引
        a[-1.23] = true;    //创建一个属性 '-1.23'
        a['1000'] = 0;     // 第1001个元素
        a[1.000] = 1;      // a[1] = 1

        数组特殊之处：只要使用使用 2^32次方-1的非负整数作为属性名，数组自动维护length

2. 测试属性： 
  let o = {x: 1};
  "x" in o    //true
  "toString" in o // true 

  o.hasOwnProperty("x")   // true： o有自有属性x
  o.hasOwnProperty("toString")   //false: toString是继承属性
  // 对象的hasOwnProperty()方法用于测试对象是否有给定名字的属性。继承的属性返回false

  // propertyIsEnumerable()方法,
  // 细化了hasOwnProperty(),
  // 自有属性  + 这个属性的enumerable特性为true => true。
  // 某些内置属性是不可枚举的。使用常规js代码创建的属性都是可枚举的 ( 除非使用14.1节的技术将它们限制为不可枚举)
  o.propertyIsEnumerable('x');    // true,
  o.propertyIsEnumerable('toString')  //false
  Object.prototype.propertyIsEnumerable('toString')   // false： 不可枚举


  // 确保不是未定义还可以 !== 
  o.x !== undefined   // true 
  o.y !== undefined   // false 
  o.toString !== undefined    // true: o继承了toString属性

// about offical accounts

export function jsSdkConfig(axios, host) {
  let u = window.navigator.userAgent;
  let isAndroid = u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端
  let isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
  //安卓需要使用当前URL进行微信API注册（即当场调用location.href.split('#')[0]）
  //iOS需要使用进入页面的初始URL进行注册，（即在任何pushstate发生前，调用location.href.split('#')[0]）
  let url = '';
  if (isiOS) {
      url = encodeURIComponent(`http://www.qq.com/home/index?op=${window.sessionStorage.getItem('option')}`);//获取初始化的url相关参数
  } else {
      url = encodeURIComponent(window.location.href.split('#')[0]);
  }

  let time = Math.round(new Date().getTime() / 1000); //获取10位时间戳
  // alert(window.location.href.split('#')[0]);
  axios.get(`${host}/wechat/getJsSDKConfig?timestamp=${time}&nonceStr=nonceStr&url=${url}`).then(function (response) {
      if (response.data.state === 0) {
          /*配置微信jssdk*/
          window.wx.config({
              debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
              appId: response.data.data.appId, // 必填，企业号的唯一标识，此处填写企业号corpid
              timestamp: response.data.data.timestamp, // 必填，生成签名的时间戳（10位）
              nonceStr: response.data.data.nonceStr, // 必填，生成签名的随机串,注意大小写
              signature: response.data.data.signature,// 必填，签名，见附录1（通过https://mp.weixin.qq.com/debug/cgi-bin/sandbox?t=jsapisign 验证）
              jsApiList: [
                  'getLocation',
                  'onMenuShareTimeline',
                  'onMenuShareAppMessage'
              ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
          });
      }
  }).catch(function (errors) {
      console.log('errors', errors);
  });
}

// professtional




































































































