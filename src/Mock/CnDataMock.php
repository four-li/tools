<?php
/**                                                             ";
 * date: 2019/8/28
 * author: four-li
 */

namespace FourLi\Tools\Mock;

use Curl\Curl;

/**
 * Class CnDataMock
 *
 * 模拟中文数据
 *
 * @package FourLi\Tools\Mock
 */
class CnDataMock
{

    /**
     * - 【 随机头像 】
     */
    function getAvatar(): string
    {
        $curl = new Curl();

        $result = $curl->get("https://api.uomg.com/api/rand.img1?format=json");

        try {
            $arr = json_decode($result, true);
        } catch (\Exception $e) {
            return '';
        }

        if ($arr['code'] == 1) {
            return $arr['imgurl'];
        } else {
            # $arr['msg'];
        }

        return '';
    }

    /**
     * - i.e. 获得随机英文字符串
     *
     * @param int  $len     生成的长度
     * @param bool $case    默认小写 true为包含大写
     * @param bool $num     默认为不含数字
     * @param bool $special 默认没有符号
     * @return string
     */
    function getRandomStr($len, $case = false, $num = false, $special = false)
    {
        $chars = ["a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z"];
        if ($case) $chars = array_merge($chars, ["A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z",]);
        if ($num) $chars = array_merge($chars, [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
        if ($special) $chars = array_merge($chars, ["!", "@", "#", "$", "?", "|", "{", "/", ":", ";", "%", "^", "&", "*", "(", ")", "-", "_", "[", "]", "}", "<", ">", "~", "+", "=", ",", "."]);

        $charsLen = count($chars) - 1;
        shuffle($chars);                            //打乱数组顺序
        $str = '';
        for ($i = 0; $i < $len; $i++) {
            $str .= $chars[mt_rand(0, $charsLen)];    //随机取出一位
        }
        return $str;
    }

    public function getEmail()
    {
        $len     = mt_rand(5, 10);
        $prefix  = $this->getRandomStr($len, 0, 1, 0);
        $domains = ['qq', 'gmail', '163', 'yahoo', 'msn', 'hotmail', 'ask', 'live', '163.net', '263.net', 'yeah.net', 'mail', 'sohu', 'sina'];
        $domain  = $domains[array_rand($domains, 1)];

        return $prefix . '@' . $domain . '.com';
    }

    public function getNodeNo($length = 20): string
    {
        return substr(strtolower(substr(md5(serialize([
                'time' => microtime(true),
                's'    => mt_rand(10000, 99999999)
            ])), 0, 30)) . strtolower(substr(md5(serialize([
                'time' => microtime(true),
                's'    => mt_rand(10000, 99999999)
            ])), 0, 30)), 0, $length);
    }

    public function getMobile()
    {
        $arr = array(
            130, 131, 132, 133, 134, 135, 136, 137, 138, 139,
            144, 147,
            150, 151, 152, 153, 155, 156, 157, 158, 159,
            176, 177, 178,
            180, 181, 182, 183, 184, 185, 186, 187, 188, 189,
        );

        return (int)($arr[array_rand($arr)] . mt_rand(1000, 9999) . mt_rand(1000, 9999));
    }

    /**
     * - i.e. 获取短文字
     * - e.g.
     *
     * @return string
     */
    public function getText()
    {
        $tou = array('快乐', '冷静', '醉熏', '潇洒', '糊涂', '积极', '冷酷', '深情', '粗暴', '温柔', '可爱', '愉快', '义气', '认真', '威武', '帅气', '传统', '潇洒', '漂亮', '自然', '专一', '听话', '昏睡', '狂野', '等待', '搞怪', '幽默', '魁梧', '活泼', '开心', '高兴', '超帅', '留胡子', '坦率', '直率', '轻松', '痴情', '完美', '精明', '无聊', '有魅力', '丰富', '繁荣', '饱满', '炙热', '暴躁', '碧蓝', '俊逸', '英勇', '健忘', '故意', '无心', '土豪', '朴实', '兴奋', '幸福', '淡定', '不安', '阔达', '孤独', '独特', '疯狂', '时尚', '落后', '风趣', '忧伤', '大胆', '爱笑', '矮小', '健康', '合适', '玩命', '沉默', '斯文', '香蕉', '苹果', '鲤鱼', '鳗鱼', '任性', '细心', '粗心', '大意', '甜甜', '酷酷', '健壮', '英俊', '霸气', '阳光', '默默', '大力', '孝顺', '忧虑', '着急', '紧张', '善良', '凶狠', '害怕', '重要', '危机', '欢喜', '欣慰', '满意', '跳跃', '诚心', '称心', '如意', '怡然', '娇气', '无奈', '无语', '激动', '愤怒', '美好', '感动', '激情', '激昂', '震动', '虚拟', '超级', '寒冷', '精明', '明理', '犹豫', '忧郁', '寂寞', '奋斗', '勤奋', '现代', '过时', '稳重', '热情', '含蓄', '开放', '无辜', '多情', '纯真', '拉长', '热心', '从容', '体贴', '风中', '曾经', '追寻', '儒雅', '优雅', '开朗', '外向', '内向', '清爽', '文艺', '长情', '平常', '单身', '伶俐', '高大', '懦弱', '柔弱', '爱笑', '乐观', '耍酷', '酷炫', '神勇', '年轻', '唠叨', '瘦瘦', '无情', '包容', '顺心', '畅快', '舒适', '靓丽', '负责', '背后', '简单', '谦让', '彩色', '缥缈', '欢呼', '生动', '复杂', '慈祥', '仁爱', '魔幻', '虚幻', '淡然', '受伤', '雪白', '高高', '糟糕', '顺利', '闪闪', '羞涩', '缓慢', '迅速', '优秀', '聪明', '含糊', '俏皮', '淡淡', '坚强', '平淡', '欣喜', '能干', '灵巧', '友好', '机智', '机灵', '正直', '谨慎', '俭朴', '殷勤', '虚心', '辛勤', '自觉', '无私', '无限', '踏实', '老实', '现实', '可靠', '务实', '拼搏', '个性', '粗犷', '活力', '成就', '勤劳', '单纯', '落寞', '朴素', '悲凉', '忧心', '洁净', '清秀', '自由', '小巧', '单薄', '贪玩', '刻苦', '干净', '壮观', '和谐', '文静', '调皮', '害羞', '安详', '自信', '端庄', '坚定', '美满', '舒心', '温暖', '专注', '勤恳', '美丽', '腼腆', '优美', '甜美', '甜蜜', '整齐', '动人', '典雅', '尊敬', '舒服', '妩媚', '秀丽', '喜悦', '甜美', '彪壮', '强健', '大方', '俊秀', '聪慧', '迷人', '陶醉', '悦耳', '动听', '明亮', '结实', '魁梧', '标致', '清脆', '敏感', '光亮', '大气', '老迟到', '知性', '冷傲', '呆萌', '野性', '隐形', '笑点低', '微笑', '笨笨', '难过', '沉静', '火星上', '失眠', '安静', '纯情', '要减肥', '迷路', '烂漫', '哭泣', '贤惠', '苗条', '温婉', '发嗲', '会撒娇', '贪玩', '执着', '眯眯眼', '花痴', '想人陪', '眼睛大', '高贵', '傲娇', '心灵美', '爱撒娇', '细腻', '天真', '怕黑', '感性', '飘逸', '怕孤独', '忐忑', '高挑', '傻傻', '冷艳', '爱听歌', '还单身', '怕孤单', '懵懂');

        $do = array("的", "爱", "", "与", "给", "扯", "和", "用", "方", "打", "就", "迎", "向", "踢", "笑", "闻", "有", "等于", "保卫", "演变");

        $wei = array('嚓茶', '凉面', '便当', '毛豆', '花生', '可乐', '灯泡', '哈密瓜', '野狼', '背包', '眼神', '缘分', '雪碧', '人生', '牛排', '蚂蚁', '飞鸟', '灰狼', '斑马', '汉堡', '悟空', '巨人', '绿茶', '自行车', '保温杯', '大碗', '墨镜', '魔镜', '煎饼', '月饼', '月亮', '星星', '芝麻', '啤酒', '玫瑰', '大叔', '小伙', '哈密瓜，数据线', '太阳', '树叶', '芹菜', '黄蜂', '蜜粉', '蜜蜂', '信封', '西装', '外套', '裙子', '大象', '猫咪', '母鸡', '路灯', '蓝天', '白云', '星月', '彩虹', '微笑', '摩托', '板栗', '高山', '大地', '大树', '电灯胆', '砖头', '楼房', '水池', '鸡翅', '蜻蜓', '红牛', '咖啡', '机器猫', '枕头', '大船', '诺言', '钢笔', '刺猬', '天空', '飞机', '大炮', '冬天', '洋葱', '春天', '夏天', '秋天', '冬日', '航空', '毛衣', '豌豆', '黑米', '玉米', '眼睛', '老鼠', '白羊', '帅哥', '美女', '季节', '鲜花', '服饰', '裙子', '白开水', '秀发', '大山', '火车', '汽车', '歌曲', '舞蹈', '老师', '导师', '方盒', '大米', '麦片', '水杯', '水壶', '手套', '鞋子', '自行车', '鼠标', '手机', '电脑', '书本', '奇迹', '身影', '香烟', '夕阳', '台灯', '宝贝', '未来', '皮带', '钥匙', '心锁', '故事', '花瓣', '滑板', '画笔', '画板', '学姐', '店员', '电源', '饼干', '宝马', '过客', '大白', '时光', '石头', '钻石', '河马', '犀牛', '西牛', '绿草', '抽屉', '柜子', '往事', '寒风', '路人', '橘子', '耳机', '鸵鸟', '朋友', '苗条', '铅笔', '钢笔', '硬币', '热狗', '大侠', '御姐', '萝莉', '毛巾', '期待', '盼望', '白昼', '黑夜', '大门', '黑裤', '钢铁侠', '哑铃', '板凳', '枫叶', '荷花', '乌龟', '仙人掌', '衬衫', '大神', '草丛', '早晨', '心情', '茉莉', '流沙', '蜗牛', '战斗机', '冥王星', '猎豹', '棒球', '篮球', '乐曲', '电话', '网络', '世界', '中心', '鱼', '鸡', '狗', '老虎', '鸭子', '雨', '羽毛', '翅膀', '外套', '火', '丝袜', '书包', '钢笔', '冷风', '八宝粥', '烤鸡', '大雁', '音响', '招牌', '胡萝卜', '冰棍', '帽子', '菠萝', '蛋挞', '香水', '泥猴桃', '吐司', '溪流', '黄豆', '樱桃', '小鸽子', '小蝴蝶', '爆米花', '花卷', '小鸭子', '小海豚', '日记本', '小熊猫', '小懒猪', '小懒虫', '荔枝', '镜子', '曲奇', '金针菇', '小松鼠', '小虾米', '酒窝', '紫菜', '金鱼', '柚子', '果汁', '百褶裙', '项链', '帆布鞋', '火龙果', '奇异果', '煎蛋', '唇彩', '小土豆', '高跟鞋', '戒指', '雪糕', '睫毛', '铃铛', '手链', '香氛', '红酒', '月光', '酸奶', '银耳汤', '咖啡豆', '小蜜蜂', '小蚂蚁', '蜡烛', '棉花糖', '向日葵', '水蜜桃', '小蝴蝶', '小刺猬', '小丸子', '指甲油', '康乃馨', '糖豆', '薯片', '口红', '超短裙', '乌冬面', '冰淇淋', '棒棒糖', '长颈鹿', '豆芽', '发箍', '发卡', '发夹', '发带', '铃铛', '小馒头', '小笼包', '小甜瓜', '冬瓜', '香菇', '小兔子', '含羞草', '短靴', '睫毛膏', '小蘑菇', '跳跳糖', '小白菜', '草莓', '柠檬', '月饼', '百合', '纸鹤', '小天鹅', '云朵', '芒果', '面包', '海燕', '小猫咪', '龙猫', '唇膏', '鞋垫', '羊', '黑猫', '白猫', '万宝路', '金毛', '山水', '音响', '尊云', '西安');

        $tou_num = rand(0, 331);
        $do_num  = rand(0, 19);
        $wei_num = rand(0, 327);
        $type    = rand(0, 0);
        if ($type == 0) {
            $text = $tou[$tou_num] . $do[$do_num] . $wei[$wei_num] . $do[rand(0, 19)] . $tou[rand(0, 331)] . $do[rand(0, 19)] . $wei_num[rand(0, 327)] . $do[rand(0, 19)] . $wei_num[rand(0, 327)] . $do[rand(0, 19)] . $wei_num[rand(0, 327)] . $do[rand(0, 19)] . $wei_num[rand(0, 327)] . $do[rand(0, 19)] . $wei_num[rand(0, 327)] . $do[rand(0, 19)] . $wei_num[rand(0, 327)] . $do[rand(0, 19)] . $wei_num[rand(0, 327)] . $do[rand(0, 19)] . $wei_num[rand(0, 327)] . $do[rand(0, 19)] . $wei_num[rand(0, 327)];
        } else {
            $text = $wei[$wei_num] . $tou[$tou_num];
        }

        return $text;
    }

    /**
     * - i.e. 随机生成用户名
     * - e.g.
     *
     * @return string
     */
    public function getName()
    {
        $arrXing  = $this->getXingList();
        $numbXing = count($arrXing);
        $arrMing  = $this->getMingList();
        $numbMing = count($arrMing);

        $Xing = $arrXing[mt_rand(0, $numbXing - 1)];
        $Ming = $arrMing[mt_rand(0, $numbMing - 1)] . $arrMing[mt_rand(0, $numbMing - 1)];

        $name = $Xing . $Ming;

        return $name;

    }

    //获取姓氏
    private function getXingList()
    {
        $arrXing = array(
            '赵', '钱', '孙', '李', '周', '吴', '郑', '王', '冯', '陈', '褚', '卫', '蒋', '沈', '韩', '杨', '朱', '秦', '尤', '许', '何', '吕', '施', '张', '孔', '曹', '严', '华', '金', '魏', '陶', '姜', '戚', '谢', '邹',
            '喻', '柏', '水', '窦', '章', '云', '苏', '潘', '葛', '奚', '范', '彭', '郎', '鲁', '韦', '昌', '马', '苗', '凤', '花', '方', '任', '袁', '柳', '鲍', '史', '唐', '费', '薛', '雷', '贺', '倪', '汤', '滕', '殷', '罗',
            '毕', '郝', '安', '常', '傅', '卞', '齐', '元', '顾', '孟', '平', '黄', '穆', '萧', '尹', '姚', '邵', '湛', '汪', '祁', '毛', '狄', '米', '伏', '成', '戴', '谈', '宋', '茅', '庞', '熊', '纪', '舒', '屈', '项', '祝',
            '董', '梁', '杜', '阮', '蓝', '闵', '季', '贾', '路', '娄', '江', '童', '颜', '郭', '梅', '盛', '林', '钟', '徐', '邱', '骆', '高', '夏', '蔡', '田', '樊', '胡', '凌', '霍', '虞', '万', '支', '柯', '管', '卢', '莫',
            '柯', '房', '裘', '缪', '解', '应', '宗', '丁', '宣', '邓', '单', '杭', '洪', '包', '诸', '左', '石', '崔', '吉', '龚', '程', '嵇', '邢', '裴', '陆', '荣', '翁', '荀', '于', '惠', '甄', '曲', '封', '储', '仲', '伊',
            '宁', '仇', '甘', '武', '符', '刘', '景', '詹', '龙', '叶', '幸', '司', '黎', '溥', '印', '怀', '蒲', '邰', '从', '索', '赖', '卓', '屠', '池', '乔', '胥', '闻', '莘', '党', '翟', '谭', '贡', '劳', '逄', '姬', '申',
            '扶', '堵', '冉', '宰', '雍', '桑', '寿', '通', '燕', '浦', '尚', '农', '温', '别', '庄', '晏', '柴', '瞿', '阎', '连', '习', '容', '向', '古', '易', '廖', '庾', '终', '步', '都', '耿', '满', '弘', '匡', '国', '文',
            '寇', '广', '禄', '阙', '东', '欧', '利', '师', '巩', '聂', '关', '荆', '司马', '上官', '欧阳', '夏侯', '诸葛', '闻人', '东方', '赫连', '皇甫', '尉迟', '公羊', '澹台', '公冶', '宗政', '濮阳', '淳于', '单于', '太叔',
            '申屠', '公孙', '仲孙', '轩辕', '令狐', '徐离', '宇文', '长孙', '慕容', '司徒', '司空'
        );
        return $arrXing;

    }

    //获取名字
    private function getMingList()
    {
        $arrMing = array(
            '伟', '刚', '勇', '毅', '俊', '峰', '强', '军', '平', '保', '东', '文', '辉', '力', '明', '永', '健', '世', '广', '志', '义', '兴', '良', '海', '山', '仁', '波', '宁', '贵', '福', '生', '龙', '元', '全'
            , '国', '胜', '学', '祥', '才', '发', '武', '新', '利', '清', '飞', '彬', '富', '顺', '信', '子', '杰', '涛', '昌', '成', '康', '星', '光', '天', '达', '安', '岩', '中', '茂', '进', '林', '有', '坚', '和', '彪', '博', '诚'
            , '先', '敬', '震', '振', '壮', '会', '思', '群', '豪', '心', '邦', '承', '乐', '绍', '功', '松', '善', '厚', '庆', '磊', '民', '友', '裕', '河', '哲', '江', '超', '浩', '亮', '政', '谦', '亨', '奇', '固', '之', '轮', '翰'
            , '朗', '伯', '宏', '言', '若', '鸣', '朋', '斌', '梁', '栋', '维', '启', '克', '伦', '翔', '旭', '鹏', '泽', '晨', '辰', '士', '以', '建', '家', '致', '树', '炎', '德', '行', '时', '泰', '盛', '雄', '琛', '钧', '冠', '策'
            , '腾', '楠', '榕', '风', '航', '弘', '秀', '娟', '英', '华', '慧', '巧', '美', '娜', '静', '淑', '惠', '珠', '翠', '雅', '芝', '玉', '萍', '红', '娥', '玲', '芬', '芳', '燕', '彩', '春', '菊', '兰', '凤', '洁', '梅', '琳'
            , '素', '云', '莲', '真', '环', '雪', '荣', '爱', '妹', '霞', '香', '月', '莺', '媛', '艳', '瑞', '凡', '佳', '嘉', '琼', '勤', '珍', '贞', '莉', '桂', '娣', '叶', '璧', '璐', '娅', '琦', '晶', '妍', '茜', '秋', '珊', '莎'
            , '锦', '黛', '青', '倩', '婷', '姣', '婉', '娴', '瑾', '颖', '露', '瑶', '怡', '婵', '雁', '蓓', '纨', '仪', '荷', '丹', '蓉', '眉', '君', '琴', '蕊', '薇', '菁', '梦', '岚', '苑', '婕', '馨', '瑗', '琰', '韵', '融', '园'
            , '艺', '咏', '卿', '聪', '澜', '纯', '毓', '悦', '昭', '冰', '爽', '琬', '茗', '羽', '希', '欣', '飘', '育', '滢', '馥', '筠', '柔', '竹', '霭', '凝', '晓', '欢', '霄', '枫', '芸', '菲', '寒', '伊', '亚', '宜', '可', '姬'
            , '舒', '影', '荔', '枝', '丽', '阳', '妮', '宝', '贝', '初', '程', '梵', '罡', '恒', '鸿', '桦', '骅', '剑', '娇', '纪', '宽', '苛', '灵', '玛', '媚', '琪', '晴', '容', '睿', '烁', '堂', '唯', '威', '韦', '雯', '苇', '萱'
            , '阅', '彦', '宇', '雨', '洋', '忠', '宗', '曼', '紫', '逸', '贤', '蝶', '菡', '绿', '蓝', '儿', '翠', '烟'
        );
        return $arrMing;
    }
}
