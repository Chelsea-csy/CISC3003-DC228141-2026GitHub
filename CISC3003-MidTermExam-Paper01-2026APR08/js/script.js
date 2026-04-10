document.addEventListener('DOMContentLoaded', function() {
    const mainContainer = document.getElementById('mainContainer');
    // 左侧两个面板
    const loginPanel = document.getElementById('loginPanel');
    const welcomeLeftPanel = document.getElementById('welcomeLeftPanel');
    // 右侧两个面板
    const welcomeRightPanel = document.getElementById('welcomeRightPanel');
    const signupPanel = document.getElementById('signupPanel');
    
    // 切换按钮
    const switchToSignup = document.getElementById('switchToSignup');
    const switchToLogin = document.getElementById('switchToLogin');
    
    // 表单
    const loginForm = document.getElementById('loginForm');
    const signupForm = document.getElementById('signupForm');
    
    // 切换到注册模式（状态2）
    function setSignupMode() {
        mainContainer.classList.add('signup-mode');
        // 左侧显示 Welcome Again 面板，右侧显示 JOIN US 表单
        loginPanel.classList.remove('active-panel');
        welcomeLeftPanel.classList.add('active-panel');
        welcomeRightPanel.classList.remove('active-panel');
        signupPanel.classList.add('active-panel');
    }
    
    // 切换到登录模式（状态1）
    function setLoginMode() {
        mainContainer.classList.remove('signup-mode');
        // 左侧显示 LOG IN 表单，右侧显示 Welcome 面板
        loginPanel.classList.add('active-panel');
        welcomeLeftPanel.classList.remove('active-panel');
        welcomeRightPanel.classList.add('active-panel');
        signupPanel.classList.remove('active-panel');
    }
    
    // 绑定切换事件
    if (switchToSignup) {
        switchToSignup.addEventListener('click', function(e) {
            e.preventDefault();
            setSignupMode();
        });
    }
    if (switchToLogin) {
        switchToLogin.addEventListener('click', function(e) {
            e.preventDefault();
            setLoginMode();
        });
    }
    
    // 登录验证：Email 和 Password 必填
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('loginEmail').value.trim();
        const password = document.getElementById('loginPassword').value.trim();
        if (email === '') {
            alert('❌ Email 是必填字段！');
            return;
        }
        if (password === '') {
            alert('❌ Password 是必填字段！');
            return;
        }
        alert('✅ 登录验证通过（演示模式）\n欢迎，' + email);
    });
    
    // 注册验证：Full Name, Email, Create Password 必填
    signupForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const fullname = document.getElementById('signupName').value.trim();
        const email = document.getElementById('signupEmail').value.trim();
        const password = document.getElementById('signupPassword').value.trim();
        if (fullname === '') {
            alert('❌ Full Name 是必填字段！');
            return;
        }
        if (email === '') {
            alert('❌ Email 是必填字段！');
            return;
        }
        if (password === '') {
            alert('❌ Create Password 是必填字段！');
            return;
        }
        alert('✅ 注册验证通过（演示模式）\n姓名：' + fullname + '\n邮箱：' + email);
    });
});