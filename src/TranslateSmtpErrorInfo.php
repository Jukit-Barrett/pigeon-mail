<?php

namespace Mrzkit\PigeonMail;

class TranslateSmtpErrorInfo
{
    /**
     * @var string
     */
    private $errorInfo;

    public function __construct(string $errorInfo)
    {
        $this->errorInfo = $errorInfo;
    }

    /**
     * @return string
     */
    public function getErrorInfo() : string
    {
        return $this->errorInfo;
    }

    /**
     * @desc 匹配邮箱
     * @return string
     */
    public function matchEmail() : string
    {
        preg_match_all("/\b[\w\.-]+@[\w\.-]+\.\w{2,4}\b/", $this->getErrorInfo(), $match);

        if ( !isset($match[0])) return '';

        if (empty($match[0])) return '';

        //去重
        $match = array_flip(array_flip($match[0]));

        return join(",", $match) . ":";
    }

    /**
     * @desc 翻译错误信息
     * @return string
     */
    public function translateErrorInfo() : string
    {
        $errorInfo = $this->getErrorInfo();

        if (empty($errorInfo)) return '';

        $email = self::matchEmail($errorInfo);

        if (strpos($errorInfo, 'SMTP connect() failed') !== false) {
            return $email . 'SMTP服务连接失败，请检查SMTP服务配置及邮箱地址密码是否正确';
        }

        //网易邮箱参考http://help.163.com/09/1224/17/5RAJ4LMH00753VB8.html
        if (strpos($errorInfo, 'HL:REP') !== false) {
            return $email . '该IP发送行为异常，存在接收者大量不存在情况，被临时禁止连接。请检查是否有用户发送病毒或者垃圾邮件，并核对发送列表有效性；';
        }

        if (strpos($errorInfo, 'HL:ICC') !== false) {
            return $email . '该IP同时并发连接数过大，超过了网易的限制，被临时禁止连接。请检查是否有用户发送病毒或者垃圾邮件，并降低IP并发连接数量；';
        }

        if (strpos($errorInfo, 'HL:IFC') !== false) {
            return $email . '该IP短期内发送了大量信件，超过了网易的限制，被临时禁止连接。请检查是否有用户发送病毒或者垃圾邮件，并降低发送频率；';
        }

        if (strpos($errorInfo, 'HL:MEP') !== false) {
            return $email . '该IP发送行为异常，存在大量伪造发送域域名行为，被临时禁止连接。请检查是否有用户发送病毒或者垃圾邮件，并使用真实有效的域名发送；';
        }

        if (strpos($errorInfo, 'MI:CEL') !== false) {
            return $email . '发送方出现过多的错误指令。请检查发信程序；';
        }

        if (strpos($errorInfo, 'MI:DMC') !== false) {
            return $email . '当前连接发送的邮件数量超出限制。请减少每次连接中投递的邮件数量；';
        }

        if (strpos($errorInfo, 'MI:CCL') !== false) {
            return $email . '发送方发送超出正常的指令数量。请检查发信程序；';
        }

        if (strpos($errorInfo, 'RP:DRC') !== false) {
            return $email . '当前连接发送的收件人数量超出限制。请控制每次连接投递的邮件数量；';
        }

        if (strpos($errorInfo, 'RP:CCL') !== false) {
            return $email . '发送方发送超出正常的指令数量。请检查发信程序；';
        }

        if (strpos($errorInfo, 'DT:RBL') !== false) {
            return $email . '发信IP位于一个或多个RBL里。';
        }

        if (strpos($errorInfo, 'WM:BLI') !== false) {
            return $email . '该IP不在网易允许的发送地址列表里；';
        }

        if (strpos($errorInfo, 'WM:BLU') !== false) {
            return $email . '此用户不在网易允许的发信用户列表里；';
        }

        if (strpos($errorInfo, 'DT:SPM') !== false) {
            return $email . '邮件正文带有垃圾邮件特征或发送环境缺乏规范性，被临时拒收。请保持邮件队列，两分钟后重投邮件。需调整邮件内容或优化发送环境；';
        }

        if (strpos($errorInfo, 'RP:CEL') !== false) {
            return $email . '发送方出现过多的错误指令。请检查发信程序；';
        }

        if (strpos($errorInfo, 'MI:DMC') !== false) {
            return $email . '当前连接发送的邮件数量超出限制。请控制每次连接中投递的邮件数量；';
        }

        if (strpos($errorInfo, 'MI:SFQ') !== false) {
            return $email . '发信人在15分钟内的发信数量超过限制，请控制发信频率；';
        }

        if (strpos($errorInfo, 'RP:QRC') !== false) {
            return $email . '发信方短期内累计的收件人数量超过限制，该发件人被临时禁止发信。请降低该用户发信频率；';
        }

        if (strpos($errorInfo, 'MI:NHD') !== false) {
            return $email . 'HELO命令不允许为空；';
        }

        if (strpos($errorInfo, 'MI:IMF') !== false) {
            return $email . '发信人电子邮件地址不合规范。';
        }

        if (strpos($errorInfo, 'MI:SPF') !== false) {
            return $email . '发信IP未被发送域的SPF许可。';
        }

        if (strpos($errorInfo, 'MI:DMA') !== false) {
            return $email . '该邮件未被发信域的DMARC许可。';
        }

        if (strpos($errorInfo, 'MI:STC') !== false) {
            return $email . '发件人当天的连接数量超出了限定数量，当天不再接受该发件人的邮件。请控制连接次数；';
        }

        if (strpos($errorInfo, 'RP:FRL') !== false) {
            return $email . '网易邮箱不开放匿名转发（Open relay）；';
        }

        if (strpos($errorInfo, 'RP:RCL') !== false) {
            return $email . '群发收件人数量超过了限额，请减少每封邮件的收件人数量；';
        }

        if (strpos($errorInfo, 'RP:TRC') !== false) {
            return $email . '发件人当天内累计的收件人数量超过限制，当天不再接受该发件人的邮件。请降低该用户发信频率；';
        }

        if (strpos($errorInfo, 'DT:SPM') !== false) {
            return $email . '邮件正文带有很多垃圾邮件特征或发送环境缺乏规范性。需调整邮件内容或优化发送环境；';
        }

        if (strpos($errorInfo, 'DT:SPM') !== false) {
            return $email . '发送的邮件内容包含了未被许可的信息，或被系统识别为垃圾邮件。请检查是否有用户发送病毒或者垃圾邮件；';
        }

        if (strpos($errorInfo, 'DT:SUM') !== false) {
            return $email . '信封发件人和信头发件人不匹配；';
        }

        if (strpos($errorInfo, 'HL:IHU') !== false) {
            return $email . '发信IP因发送垃圾邮件或存在异常的连接行为，被暂时挂起。请检测发信IP在历史上的发信情况和发信程序是否存在异常；';
        }

        if (strpos($errorInfo, 'HL:IPB') !== false) {
            return $email . '该IP不在网易允许的发送地址列表里；';
        }

        if (strpos($errorInfo, 'MI:STC') !== false) {
            return $email . '发件人当天内累计邮件数量超过限制，当天不再接受该发件人的投信。请降低发信频率；';
        }

        if (strpos($errorInfo, 'MI:SPB') !== false) {
            return $email . '此用户不在网易允许的发信用户列表里；';
        }

        if (strpos($errorInfo, 'Requested mail action aborted: exceeded mailsize limit') !== false) {
            return $email . '发送的信件大小超过了网易邮箱允许接收的最大限制；';
        }

        if (strpos($errorInfo, 'Requested action not taken: NULL sender is not allowed') !== false) {
            return $email . '不允许发件人为空，请使用真实发件人发送；';
        }

        if (strpos($errorInfo, 'Requested action not taken: Local user only') !== false) {
            return $email . 'SMTP类型的机器只允许发信人是本站用户；';
        }

        if (strpos($errorInfo, 'Requested action not taken: no smtp MX only') !== false) {
            return $email . 'MX类型的机器不允许发信人是本站用户；';
        }

        if (strpos($errorInfo, 'authentication is required') !== false) {
            return $email . 'SMTP需要身份验证，请检查客户端设置；';
        }

        if (strpos($errorInfo, 'IP is rejected, smtp auth error limit exceed') !== false) {
            return $email . '该IP验证失败次数过多，被临时禁止连接。请检查验证信息设置；';
        }

        if (strpos($errorInfo, 'IP in blacklist') !== false) {
            return $email . '该IP不在网易允许的发送地址列表里。';
        }

        if (strpos($errorInfo, 'Invalid User') !== false) {
            return $email . '请求的用户不存在；';
        }

        if (strpos($errorInfo, 'User in blacklist') !== false) {
            return $email . '该用户不被允许给网易用户发信；';
        }

        if (strpos($errorInfo, 'User suspended') !== false) {
            return $email . '请求的用户处于禁用或者冻结状态；';
        }

        if (strpos($errorInfo, 'Requested mail action not taken: too much recipient') !== false) {
            return $email . '群发数量超过了限额；';
        }

        if (strpos($errorInfo, 'Illegal Attachment') !== false) {
            return $email . '不允许发送该类型的附件，包括以.uu .pif .scr .mim .hqx .bhx .cmd .vbs .bat .com .vbe .vb .js .wsh等结尾的附件；';
        }

        if (strpos($errorInfo, 'Requested action not taken: NULL sender is not allowed') !== false) {
            return $email . '不允许发件人为空，请使用真实发件人发送；';
        }

        if (strpos($errorInfo, 'Requested action not taken: Local user only') !== false) {
            return $email . 'SMTP类型的机器只允许发信人是本站用户；';
        }

        if (strpos($errorInfo, 'Requested action not taken: no smtp MX only') !== false) {
            return $email . 'MX类型的机器不允许发信人是本站用户；';
        }

        if (strpos($errorInfo, 'Requested mail action not taken: too much fail authentication') !== false) {
            return $email . '登录失败次数过多，被临时禁止登录。请检查密码与帐号验证设置；';
        }

        if (strpos($errorInfo, 'Requested action aborted: local error in processing') !== false) {
            return $email . '系统暂时出现故障，请稍后再次尝试发送；';
        }

        if (strpos($errorInfo, 'Error: bad syntaxU') !== false) {
            return $email . '发送的smtp命令语法有误；';
        }

        //腾讯邮箱参考https://service.mail.qq.com/cgi-bin/help?id=20022
        if (strpos($errorInfo, 'Mail content denied') !== false) {
            return $email . '该邮件内容涉嫌大量群发，并且被多数用户投诉为垃圾邮件。';
        }

        if (strpos($errorInfo, 'Connection frequency limited') !== false) {
            return $email . '服务器IP的发信频率超过腾讯邮箱限制。';
        }

        if (strpos($errorInfo, 'Suspected bounce attacks') !== false) {
            return $email . '疑似退信攻击。发生此问题，可能是你的邮件服务器接收了仿冒qq.com账号发出的垃圾邮件，并且你的邮件服务器没有检查发件人真实性，在某种条件下触发了退信。';
        }

        if (strpos($errorInfo, 'Spam is embedded in the email') !== false) {
            return $email . '该邮件内容用户自定义部分被嵌入了垃圾信息，被大量用户投诉为垃圾邮件，QQ邮箱将禁止此类邮件内容的发送。';
        }

        if (strpos($errorInfo, 'Suspected spam ip') !== false) {
            return $email . 'IP 发送大量垃圾邮件，或所发送的邮件收件人存在大量的不存在账号。';
        }

        if (strpos($errorInfo, 'Suspected spam') !== false) {
            return $email . '疑似垃圾邮件，大量的垃圾邮件发送自该域名或邮件运营商。如果你是邮件运营商，请重视垃圾邮件及垃圾用户的管理，避免被滥用。';
        }

        if (strpos($errorInfo, 'SPF check failed') !== false) {
            return $email . '发信域名设置了SPF，但检查未通过验证。如有新增ip，请及时更新SPF记录。';
        }

        if (strpos($errorInfo, 'Mail is rejected by recipients') !== false) {
            return $email . '用户设置个人黑名单或者过滤器拒收';
        }

        if (strpos($errorInfo, 'Mailbox unavailable or access denied') !== false) {
            return $email . '您要发送的收件人短时间内收到大量邮件，为避免受到恶意攻击，暂时禁止向该收件人发信。';
        }

        if (strpos($errorInfo, 'Bad address syntax') !== false) {
            return $email . '您所填写的收件人地址格式不正确。';
        }

        if (strpos($errorInfo, 'Message too large') !== false) {
            return $email . '您所发送的邮件大小超出腾讯邮箱限制。';
        }

        if (strpos($errorInfo, 'Mailbox not found') !== false) {
            return $email . '您要发送的收件人不存在。';
        }

        if (strpos($errorInfo, 'Mailbox not found or access denied') !== false) {
            return $email . '您要发送的收件人不存在或者禁止向该收件人发信';
        }

        if (strpos($errorInfo, 'Connection denied') !== false) {
            return $email . '该服务器IP的发信频率大幅度超过QQ邮箱限制。';
        }

        if (strpos($errorInfo, 'Mail content denied') !== false) {
            return $email . '该邮件内容涉嫌大量群发，并且被多数用户投诉为垃圾邮件。';
        }

        if (strpos($errorInfo, 'Ip frequency limited') !== false) {
            return $email . '该服务器IP的发信频率超过腾讯邮箱限制。';
        }

        if (strpos($errorInfo, 'Domain frequency limited') !== false) {
            return $email . '该发件人域名的发信频率超过腾讯邮箱限制。';
        }

        if (strpos($errorInfo, 'Sender frequency limited') !== false) {
            return $email . '该发件人的发信频率超过腾讯邮箱限制。';
        }

        if (strpos($errorInfo, 'Connection frequency limited') !== false) {
            return $email . '该服务器IP的发信频率超过腾讯邮箱限制。';
        }

        //其它邮箱
        if (strpos($errorInfo, 'Service not available') !== false) {
            return $email . '服务不可用';
        }

        if (strpos($errorInfo, 'Resources temporarily unavailable') !== false) {
            return $email . '资源暂时不可用。';
        }

        if (strpos($errorInfo, 'User not found') !== false) {
            return $email . '用户不存在。';
        }

        if (strpos($errorInfo, 'You must provide at least one recipient email address.') !== false) {
            return $email . '您必须提供至少一个收件人电子邮件地址';
        }

        if (
            strpos($errorInfo, 'recipient is not exist') !== false
            || (strpos($errorInfo, "dosn't exist") !== false && strpos($errorInfo, 'RCPT') !== false)
        ) {
            return $email . '收件人不存在';
        }

        if (strpos($errorInfo, 'MAIL FROM command failed') !== false) {
            return $email . '发件人错误';
        }

        if (strpos($errorInfo, 'queue file write error') !== false) {
            return $email . '队列文件写入错误，可能是由于邮件内容过大';
        }

        if (strpos($errorInfo, 'need RCPT command') !== false) {
            return $email . '收件人地址异常';
        }

        if (strpos($errorInfo, 'Could not authenticate') !== false) {
            return $email . '无法认证，建议检查账号密码是否正确，以及是否设置了双重密码';
        }

        if (strpos($errorInfo, 'data not accepted.SMTP server error: DATA END command failed') !== false) {
            return $email . '数据不被接受';
        }

        if (strpos($errorInfo, 'Invalid address') !== false) {
            return $email . '失效的邮箱地址';
        }

        if (strpos($errorInfo, 'data not accepted') !== false) {
            return $email . '数据不接受，请确保已经开启了 SMTP 邮件服务';
        }

        return $errorInfo;
    }
}
