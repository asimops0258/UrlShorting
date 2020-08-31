<?php require_once "header.php"; ?>
<div class="mdui-container doc-container">
    <div class="mdui-typo">
        <h2>幫助</h2>
        1.輸入短網址時請加上http(s)://<br />
        2.中文網址請使用Punycode編碼後再使用<br />
        3.網址最長支援1000字符<br />
        4.密語最長支援3000字符(大約1000漢字)<br />
        5.自訂短網址 Or 密码(選填)<br />
        6.密碼限制2-20位(英數組合)/短網址限制輸入<?php echo $pass ?>位<br />
    </div>
</div>
<div class="mdui-container doc-container">
    <div class="mdui-typo">
        <h2>Api接口</h2>
        <div class="mdui-table-fluid">
            <table class="mdui-table mdui-table-hoverable">
                <tbody>
                    <tr>
                        <td>接口地址</td>
                        <td>
                            <?php echo $url ?>api.php</td>
                    </tr>
                    <tr>
                        <td>注意</td>
                        <td>請使用post來訪問Api</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mdui-table-fluid">
            <table class="mdui-table mdui-table-hoverable">
                <thead>
                    <tr>
                        <th>變數名稱</th>
                        <th>含義</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>url</td>
                        <td>需要縮址的網址(優先於密語)</td>
                    </tr>
                    <tr>
                        <td>message</td>
                        <td>需要縮短的密語</td>
                    </tr>
                    <tr>
                        <td>shorturl</td>
                        <td>自定短網址(選填)</td>
                    </tr>
                    <tr>
                        <td>passwd</td>
                        <td>加密密碼(選填)</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mdui-table-fluid">
            <table class="mdui-table mdui-table-hoverable">
                <thead>
                    <tr>
                        <th>返回值(json)</th>
                        <th>含義</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>code</td>
                        <td>狀態碼,參照下表</td>
                    </tr>
                    <tr>
                        <td>shorturl</td>
                        <td>生成的短網址,只有在code為200時才會返回</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="mdui-container doc-container">
            <div class="mdui-typo">
                <h2>狀態碼表</h2>
                <div class="mdui-table-fluid">
                    <table class="mdui-table mdui-table-hoverable">
                        <thead>
                            <tr>
                                <th>狀態碼</th>
                                <th>含義</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>200</td>
                                <td>成功</td>
                            </tr>
                            <tr>
                                <td>1002</td>
                                <td>您的IP或短網址被管理員封鎖</td>
                            </tr>
                            <tr>
                                <td>1001</td>
                                <td>未經授權的輸入</td>
                            </tr>
                            <tr>
                                <td>2001/2002</td>
                                <td>不合法的自定義短網址</td>
                            </tr>
                            <tr>
                                <td>2003</td>
                                <td>自訂義名稱已被使用</td>
                            </tr>
                            <tr>
                                <td>3001/3002</td>
                                <td>未經授權的密碼</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once "footer.php"; ?>
