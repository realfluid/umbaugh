SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE IF NOT EXISTS `#__sl_SpamFilter` (
  `id` int(11) NOT NULL auto_increment,
  `time` int(11) NOT NULL,
  `type` int(1) NOT NULL COMMENT '0-Settings, 1-EMail, 2-UserName, 3-IP, 4-Term',
  `term` varchar(128) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8183 ;

INSERT INTO `#__sl_SpamFilter` (`id`, `time`, `type`, `term`) VALUES
(1, 0, 0, '#Last Update#'),
(2, 1290180024, 1, 'bradley_12352@yahoo.com'),
(3, 1290180024, 1, 'eczemafreeforever@hotmail.com'),
(4, 1290180024, 1, 'ridceubo@gmail.com'),
(5, 1290180024, 1, 'annawerner23@hotmail.com'),
(6, 1290180024, 1, 'kissinggames22@gmail.com'),
(7, 1290180024, 1, 'vincentnivea25@gmail.com'),
(8, 1290180024, 1, 'julik2511@zing.vn'),
(9, 1290180024, 1, 'floyd54horn@hotmail.com'),
(10, 1290180024, 1, 'akachhwaha143@gmail.com'),
(11, 1290180024, 1, 'macluwis@yahoo.co.uk'),
(12, 1290180024, 1, 'jamestrune@aol.com'),
(13, 1290180024, 1, 'ryan95daisy@gmail.com'),
(14, 1290180024, 1, 'braddhodge@hotmail.com'),
(15, 1290180024, 1, 'aardentlimo007@gmail.com'),
(16, 1290180024, 1, 'a.babayan@hotmail.com'),
(17, 1290180024, 1, 'oliver2gill@yahoo.co.uk'),
(18, 1290180024, 1, 'marcel82brennan@aol.com'),
(19, 1290180024, 1, 'superdupergreenmom@grensupply.net'),
(20, 1290180024, 1, 'lionfischer2@yahoo.co.uk'),
(21, 1290180024, 1, 'tok24seo@gmail.com'),
(22, 1290180024, 1, 'armand94keller@yahoo.co.uk'),
(23, 1290180024, 1, 'blossersbalob@hotmail.com'),
(24, 1290180024, 1, 'laurecruzeqa@hotmail.com'),
(25, 1290180024, 1, 'stevelewis7777@gmail.com'),
(26, 1290180024, 1, 'tcindia123@gmail.com'),
(27, 1290180024, 1, 'esurkes@gmail.com'),
(28, 1290180024, 1, 'dryiceretailers@yahoo.com'),
(29, 1290180024, 1, 'matadorre@hotmail.de'),
(30, 1290180024, 1, 'aquafina222@gmail.com'),
(31, 1290180024, 1, 'ritobana@ozawamail.com'),
(32, 1290180024, 1, 'tsr@topsoftwareratings.com'),
(33, 1290180024, 1, 'sanford6pickett@hotmail.fi'),
(34, 1290180024, 1, 'topofnews@gmail.com'),
(35, 1290180024, 1, 'stubborn203@hotmail.com'),
(36, 1290180024, 1, 'pippop64@gmail.com'),
(37, 1290180024, 1, 'trucksgame@gmail.com'),
(38, 1290180024, 1, 'masti2day@yashwantdedcollege.com'),
(39, 1290180024, 1, 'mex3@farm123.com'),
(40, 1290180024, 1, 'greengadgets12@hotmail.com'),
(41, 1290180024, 1, 'bobaoseo@yahoo.cn'),
(42, 1290180024, 1, 'yolandazsanchez@gmail.com'),
(43, 1290180024, 1, 'strike44@hotmail.com.tr'),
(44, 1290180024, 1, 'crossancatses@hotmail.com'),
(45, 1290180024, 1, 'batterycharger12@rocketmail.com'),
(46, 1290180024, 1, 'lukdarsa@gmail.com'),
(47, 1290180024, 1, 'nalejandrivuse@hotmail.com'),
(48, 1290180024, 1, 'sandiegops@hotmail.com'),
(49, 1290180024, 1, 'stubborn101@hotmail.com'),
(50, 1290180024, 1, 'lylestevens99@hotmail.com'),
(51, 1290180024, 1, 'rmedlin2@hotmail.com'),
(52, 1290180024, 1, 'zulakishaadkins5@hotmail.com'),
(53, 1290180024, 1, 'safews24@gmail.com'),
(54, 1290180024, 1, 'bestmmorpg2010@gmail.com'),
(55, 1290180024, 1, 'boxespacking@hotmail.com'),
(56, 1290180024, 1, 'bemisq9gcalliea8s@hotmail.com'),
(57, 1290180024, 1, 'nadia87njidin@yahoo.co.uk'),
(58, 1290180024, 1, 'tomandjerrys2010@hotmail.com'),
(59, 1290180024, 1, 'kingofgamesdotnet@gmail.com'),
(60, 1290180024, 1, 'oliviacerminaro812205@hotmail.com'),
(61, 1290180024, 1, 'pengiranjames@ymail.com'),
(62, 1290180024, 1, 'diana7sanders@yahoo.co.uk'),
(63, 1290180024, 1, 'masti2day@yashwantdedcollege.com'),
(64, 1290180024, 1, 'xrum124@gmail.com'),
(65, 1290180024, 1, 'downloadmusic@yashwantdedcollege.com'),
(66, 1290180024, 1, 'benito6harrison@yahoo.co.uk'),
(67, 1290180024, 1, 'fowler.bowman@yahoo.com'),
(68, 1290180024, 1, 'janakarti@gmail.com'),
(69, 1290180024, 1, 'joshzscott@aol.com'),
(70, 1290180024, 1, 'wurstred24@yahoo.co.uk'),
(71, 1290180024, 1, 'rosaline.goldingyws@hotmail.com'),
(72, 1290180024, 1, 'gubpoga@gmail.com'),
(73, 1290180024, 1, 'lishiming1220@gmail.com'),
(74, 1290180024, 1, 'maynard72blackwe@hotmail.com'),
(75, 1290180024, 1, 'hunsakerjzamadashr@hotmail.com'),
(76, 1290180024, 1, 'rolandlevy917@gmail.com'),
(77, 1290180024, 1, 'ismayil7koc@yahoo.co.uk'),
(78, 1290180024, 1, 'royce13wolfe@yahoo.co.uk'),
(79, 1290180024, 1, 'andy5morris@yahoo.co.uk'),
(80, 1290180024, 1, 'sunpay12@yopmail.com'),
(81, 1290180024, 1, 'srui84@yahoo.com'),
(82, 1290180024, 1, 'eloymyer@ymail.com'),
(83, 1290180024, 1, 'karcandanoc@hotmail.com'),
(84, 1290180024, 1, 'andropenis@freestuffff.net'),
(85, 1290180024, 1, 'prashantrocks@yashwantdedcollege.com'),
(86, 1290180024, 1, 'vandeheybmec@hotmail.com'),
(87, 1290180024, 1, 'rugsale@hotmail.com'),
(88, 1290180024, 1, 'capsi@capsiplexstore.co.uk'),
(89, 1290180024, 1, 'fidelphone9@yahoo.co.uk'),
(90, 1290180024, 1, 'art3larsen@marmoon.com'),
(91, 1290180024, 1, 'greenrent30@yahoo.com'),
(92, 1290180024, 1, 'linkbuildermail@gmail.com'),
(93, 1290180024, 1, 'bernardceciliat@gmail.com'),
(94, 1290180024, 1, 'burton71stephens@hotmail.com'),
(95, 1290180024, 1, 'yinglisunrent@yahoo.com'),
(96, 1290180024, 1, 'nwohlfarthoing@hotmail.com'),
(97, 1290180024, 1, 'ottottopitts67@yahoo.co.uk'),
(98, 1290180024, 1, 'wardenfulton09@yahoo.co.uk'),
(99, 1290180024, 1, 'carloschultejkh@gmail.com'),
(100, 1290180024, 1, 'kimwills43@aol.com'),
(101, 1290180024, 1, 'madietrey@gmail.com'),
(102, 1290180024, 1, 'mahmut87erdogan@yahoo.co.uk'),
(103, 1290180024, 1, 'mrbharris1978@aim.com'),
(104, 1290180024, 1, 'jan@pol.pl'),
(105, 1290180024, 1, 'selt@howtogetstrongfast.info'),
(106, 1290180024, 1, 'jackie261allison@yahoo.co.uk'),
(107, 1290180024, 1, 'ricardo77@hotmail.com.tr'),
(108, 1290180024, 1, 'willie7r@hotmail.com'),
(109, 1290180024, 1, 'delagarzaxpelnaj09@hotmail.com'),
(110, 1290180024, 1, 'vito33whitehead@yahoo.co.uk'),
(111, 1290180024, 1, 'rivav4lundi2a7@hotmail.com'),
(112, 1290180024, 1, 'amittcet@gmail.com'),
(113, 1290180024, 1, 'yeastrol@freestuffff.net'),
(114, 1290180024, 1, 'catwoman125mom@aol.com'),
(115, 1290180024, 1, 'lane9levy6@yahoo.co.uk'),
(116, 1290180024, 1, 'jean1@bestcheapreview.com'),
(117, 1290180024, 1, 'hoteltravelvietnamcom@gmail.com'),
(118, 1290180024, 1, 'heath35landry@yahoo.co.uk'),
(119, 1290180024, 1, 'casey229ortiz@yahoo.co.uk'),
(120, 1290180024, 1, 'dougm6uhco@yahoo.co.uk'),
(121, 1290180024, 1, 'iveyknos@hotmail.com'),
(122, 1290180024, 1, 'seebe@howtostudyhard.info'),
(123, 1290180024, 1, 'iturbervilvanel@hotmail.com'),
(124, 1290180024, 1, 'daryl96boyd@yahoo.co.uk'),
(125, 1290180024, 1, 'forest38roberson@yahoo.co.uk'),
(126, 1290180024, 1, 'rick48schaefer@hotmail.com'),
(127, 1290180024, 1, 'kleonmitt@gmail.com'),
(128, 1290180024, 1, 'makemybabyonline@yahoo.com'),
(129, 1290180024, 1, 'tiffany@yashwantdedcollege.com'),
(130, 1290180024, 1, 'iturbervilvanel@hotmail.com'),
(131, 1290180024, 1, 'virgil1sheppard@bemymd.com'),
(132, 1290180024, 1, 'battlerichard277@gmail.com'),
(133, 1290180024, 1, 'belenevansdd16517@yahoo.com'),
(134, 1290180024, 1, 'directory5432@yahoo.com'),
(135, 1290180024, 1, 'bryce5tran@yahoo.co.uk'),
(136, 1290180024, 1, 'ronald321t3@yahoo.co.uk'),
(137, 1290180024, 1, 'juliadav123@gmail.com'),
(138, 1290180024, 1, 'mirato51@yahoo.co.uk'),
(139, 1290180024, 1, 'kshaquanaleypl@hotmail.com'),
(140, 1290180024, 1, 'earl57marquez@aol.com'),
(141, 1290180024, 1, 'merle31bowman@yahoo.co.uk'),
(142, 1290180024, 1, 'sonny1mcpherson@hotmail.com'),
(143, 1290180024, 1, 'lili79vardyz@yahoo.co.uk'),
(144, 1290180024, 1, 'chrismooney@perfumeinfo.net'),
(145, 1290180024, 1, 'thefutoncovers@gmail.com'),
(146, 1290180024, 1, 'linda2davenport@yahoo.co.uk'),
(147, 1290180024, 1, 'munchenflughafen@ymail.com'),
(148, 1290180024, 1, 'tjordan2020@gmail.com'),
(149, 1290180024, 1, 'kylemaniaa@gmail.com'),
(150, 1290180024, 1, 'trinnity80@gmail.com'),
(151, 1290180024, 1, 'allegraisyeiraes@gmail.com'),
(152, 1290180024, 1, 'arnettejiluns@hotmail.com'),
(153, 1290180024, 1, 'danwestly01@aol.com'),
(154, 1290180024, 1, 'cloyd.zolan27@hotmail.com'),
(155, 1290180024, 1, 'glen.nokley@hotmail.com'),
(156, 1290180024, 1, 'benny4mills667@yahoo.co.uk'),
(157, 1290180024, 1, 'lucakovalsky@yahoo.co.uk'),
(158, 1290180024, 1, 'pramathnsamuelsfe@gmail.com'),
(159, 1290180024, 1, 'hothappysixteen@hotmail.com'),
(160, 1290180024, 1, 'donald28key@yahoo.co.uk'),
(161, 1290180024, 1, 'gsabomepir@hotmail.com'),
(162, 1290180024, 1, 'norman7noble@yahoo.co.uk'),
(163, 1290180024, 1, 'garland42hollowa@yahoo.co.uk'),
(164, 1290180024, 1, 'rosalbameoghte@hotmail.com'),
(165, 1290180024, 1, 'adolph517hendric@yahoo.co.uk'),
(166, 1290180024, 1, 'margarito92casey@yahoo.co.uk'),
(167, 1290180024, 1, 'jimhawk9999@gmail.com'),
(168, 1290180024, 1, 'ahhayqua@gmail.com'),
(169, 1290180024, 1, 'ersatzteiletata@yahoo.com'),
(170, 1290180024, 1, 'alvinaalbert3@yahoo.co.uk'),
(171, 1290180024, 1, 'annieperry01@gmail.com'),
(172, 1290180024, 1, 'lynn.stowe12@hotmail.com'),
(173, 1290180024, 1, 'janzlisasac@yahoo.com'),
(174, 1290180024, 1, 'henrulir@gmail.com'),
(175, 1290180024, 1, 'joycemary6young@yahoo.co.uk'),
(176, 1290180024, 1, 'jemalissakfhepley4e@hotmail.com'),
(177, 1290180024, 1, 'brgstmz@gmail.com'),
(178, 1290180024, 1, 'joan44813@yahoo.co.uk'),
(179, 1290180024, 1, 'jonathan21marsh1@yahoo.co.uk'),
(180, 1290180024, 1, 'aldo1vaughn@yahoo.co.uk'),
(181, 1290180024, 1, 'winston75sloan@yahoo.co.uk'),
(182, 1290180024, 1, 'sayre.lahoma9irh@hotmail.com'),
(183, 1290180024, 1, 'stacielohmeierjapsv@hotmail.com'),
(184, 1290180024, 1, 'jessie8silva@yahoo.co.uk'),
(185, 1290180024, 1, 'stopsmokingweed1@hotmail.com'),
(186, 1290180024, 1, 'da_high_grade@hotmail.com'),
(187, 1290180024, 1, 'shannon46kerr@yahoo.co.uk'),
(188, 1290180024, 1, 'kentucky69yamma@yahoo.co.uk'),
(189, 1290180024, 1, 'magoon.evelyneotw@hotmail.com'),
(190, 1290180024, 1, 'subway1983@yahoo.co.uk'),
(191, 1290180024, 1, 'ralph17atkinson@yahoo.co.uk'),
(192, 1290180024, 1, 'anthondarvela42@yahoo.co.uk'),
(193, 1290180024, 1, 'hann.lita8ddd@hotmail.com'),
(194, 1290180024, 1, 'salomethomas27@yahoo.co.uk'),
(195, 1290180024, 1, 'denzpertrison@yahoo.com'),
(196, 1290180024, 1, 'prhogg5cg0margarettakc@hotmail.com'),
(197, 1290180024, 1, 'yolandazsanchez@gmail.com'),
(198, 1290180024, 1, 'alexander46serra@gmail.com'),
(199, 1290180024, 1, 'alo3nzo4ngo7bui@yahoo.co.uk'),
(200, 1290180024, 1, 'belenevanszz16516@yahoo.com'),
(201, 1290180024, 1, 'rody.kowdell@mail.ru'),
(202, 1290180024, 1, 'alejandro97charl@yahoo.co.uk'),
(203, 1290180024, 1, 'andyhoney22@yahoo.com'),
(204, 1290180024, 1, 'carsparkinggames@gmail.com'),
(205, 1290180024, 1, 'sena.lashanda1px@hotmail.com'),
(206, 1290180024, 1, 'crlhdsn6@gmail.com'),
(207, 1290180024, 1, 'johnathon4brooks@yahoo.co.uk'),
(208, 1290180024, 1, 'ariana01ong@gmail.com'),
(209, 1290180024, 1, 'robertmaciejew13@yahoo.co.uk'),
(210, 1290180024, 1, 'zipkiyahsukonn@hotmail.com'),
(211, 1290180024, 1, 'dtriciapac@hotmail.com'),
(212, 1290180024, 1, 'moises75best@yahoo.co.uk'),
(213, 1290180024, 1, 'v7@mymailindex.com'),
(214, 1290180024, 1, 'asitnetwork28@sify.com'),
(215, 1290180024, 1, 'jaidevidohertylv@gmail.com'),
(216, 1290180024, 1, 'deutschlandtata@yahoo.com'),
(217, 1290180024, 1, 'gale55olsen@36ru.com'),
(218, 1290180024, 1, 'chester19booker@yahoo.co.uk'),
(219, 1290180024, 1, 'usedvanman@yahoo.co.uk'),
(220, 1290180024, 1, 'burton8sullivan@yahoo.co.uk'),
(221, 1290180024, 1, 'reginecese@hotmail.com'),
(222, 1290180024, 1, 'fgcorinnat7kroppbu@hotmail.com'),
(223, 1290180024, 1, 'growlongereyelas@hotmail.com'),
(224, 1290180024, 1, 'growingeyelashes@hotmail.com'),
(225, 1290180024, 1, 'besteyelashgrowt@hotmail.com'),
(226, 1290180024, 1, 'gesolarsunrent@ymail.com'),
(227, 1290180024, 1, 'lashgrowth23@hotmail.com'),
(228, 1290180024, 1, 'ulitkovvv@mail.ru'),
(229, 1290180024, 1, 'blueberry0306@gmail.com'),
(230, 1290180024, 1, 'cisheffieldeqvlindsayh@hotmail.com'),
(231, 1290180024, 1, 'toniamado85@gmail.com'),
(232, 1290180024, 1, 'mailsvxd45@mail321.co.uk'),
(233, 1290180024, 1, 'lavern17mccall@yahoo.co.uk'),
(234, 1290180024, 1, 'darrellsparks@32-ledtv.com'),
(235, 1290180024, 1, 'cashadvance91pa@yahoo.co.uk'),
(236, 1290180024, 1, 'revolutionarymy@sogou.com'),
(237, 1290180024, 1, 'faliano@hotmail.fr'),
(238, 1290180024, 1, 'gcotton322@yahoo.co.uk'),
(239, 1290180024, 1, 'radotty.daweso@hotmail.com'),
(240, 1290180024, 1, 'evelinakanerva@hotmail.com'),
(241, 1290180024, 1, 'andy2payne@yahoo.co.uk'),
(242, 1290180024, 1, 'ryanholloway86@hotmail.com'),
(243, 1290180024, 1, 'thchante.legaulta@hotmail.com'),
(244, 1290180024, 1, 'harrison9rice@yahoo.co.uk'),
(245, 1290180024, 1, 'program0outsourc@aol.com'),
(246, 1290180024, 1, 'dutompkins.donette2c@hotmail.com'),
(247, 1290180024, 1, 'salimhawk82@hotmail.com'),
(248, 1290180024, 1, 'mscleansing@yahoo.co.uk'),
(249, 1290180024, 1, 'ellingtonross@gmail.com'),
(250, 1290180024, 1, 'julie7stokes@yahoo.co.uk'),
(251, 1290180024, 1, 'strotheryhharriettetnna@hotmail.com'),
(252, 1290180024, 1, 'williamhowards34@yahoo.com'),
(253, 1290180024, 1, 'bob2farmer@yahoo.co.uk'),
(254, 1290180024, 1, 'k9detectiondogs@yahoo.co.uk'),
(255, 1290180024, 1, 'pedr4o58carey@yahoo.co.uk'),
(256, 1290180024, 1, 'mobilephonedistributors@gmail.com'),
(257, 1290180024, 1, 'suse28huber@yahoo.co.uk'),
(258, 1290180024, 1, 'kill71t5padilla@yahoo.co.uk'),
(259, 1290180024, 1, 'chris_197435@yahoo.com'),
(260, 1290180024, 1, 'sognomanogy@web.de'),
(261, 1290180024, 1, 'lindenbergawi@hotmail.com'),
(262, 1290180024, 1, 'versumo8@yahoo.co.uk'),
(263, 1290180024, 1, 'dainyelrisy@gmail.com'),
(264, 1290180024, 1, 'djp371@gmail.com'),
(265, 1290180024, 1, 'rusty7baird@yahoo.co.uk'),
(266, 1290180024, 1, 'jayme.howlandjkg@hotmail.com'),
(267, 1290180024, 1, 'brent6marks@yahoo.co.uk'),
(268, 1290180024, 1, 'inspiros1962@hotmail.com'),
(269, 1290180024, 1, 'trevaka@gmail.com'),
(270, 1290180024, 1, 'monassirah1980@hotmail.fr'),
(271, 1290180024, 1, 'wilbur37baird@yahoo.co.uk'),
(272, 1290180024, 1, 'haryoseo@haryoardito.com'),
(273, 1290180024, 1, 'gerardwerder81@hotmail.com'),
(274, 1290180024, 1, 'myted@binkmail.com'),
(275, 1290180024, 1, 'guydpierce2000@hotmail.com'),
(276, 1290180024, 1, 'nelsoncarrillo03@yahoo.co.uk'),
(277, 1290180024, 1, 'son2best@yahoo.co.uk'),
(278, 1290180024, 1, 'splattjanice@yahoo.co.uk'),
(279, 1290180024, 1, 'curt64sykes@yahoo.co.uk'),
(280, 1290180024, 1, 'howard14mathis@yahoo.co.uk'),
(281, 1290180024, 1, 'frank5battery@yahoo.co.uk'),
(282, 1290180024, 1, 'tom.skladany@yahoo.com'),
(283, 1290180024, 1, 'cindytan1246@yahoo.com'),
(284, 1290180024, 1, 'dusty8andrews@yahoo.co.uk'),
(285, 1290180024, 1, 'asitnetwork26@sify.com'),
(286, 1290180024, 1, 'aarondylan123@gmail.com'),
(287, 1290180024, 1, 'earlfoley4711@hotmail.com'),
(288, 1290180024, 1, 'marshall52campbe@hotmail.com'),
(289, 1290180024, 1, 'dorinda.standiferd1f@hotmail.com'),
(290, 1290180024, 1, 'naoma.longoriab1l0@hotmail.com'),
(291, 1290180024, 1, 'billy10388@yahoo.com'),
(292, 1290180024, 1, 'mordi@newaysonline.tv'),
(293, 1290180024, 1, 'stephen68cantrel@yahoo.co.uk'),
(294, 1290180024, 1, 'sue74clark@yahoo.com'),
(295, 1290180024, 1, 'greendiyenergyx@yahoo.co.uk'),
(296, 1290180024, 1, 'parker95g@hotmail.com'),
(297, 1290180024, 1, 'austink18kortneyhcv@hotmail.com'),
(298, 1290180024, 1, 'jacob19porter@yahoo.co.uk'),
(299, 1290180024, 1, 'gramehick@hotmail.com'),
(300, 1290180024, 1, 'wilson5wiley@yahoo.co.uk'),
(301, 1290180024, 1, 'formulatedconcepts@gmail.com'),
(302, 1290180024, 1, 'shawnflanery78@yahoo.co.uk'),
(303, 1290180024, 1, 'melvinopmolina@yahoo.co.uk'),
(304, 1290180024, 1, 'johandla@economicnewsblog.com'),
(305, 1290180024, 1, 'jesus8haney@yahoo.co.uk'),
(306, 1290180024, 1, 'earl58burnett@yahoo.co.uk'),
(307, 1290180024, 1, 'ali.nelson21@hotmail.com'),
(308, 1290180024, 1, 'jamie24combs@yahoo.co.uk'),
(309, 1290180024, 1, 'andi_aso2000@yahoo.com'),
(310, 1290180024, 1, 'user@looseweightnaturally.info'),
(311, 1290180024, 1, 'streamingdemon@justseeker.com'),
(312, 1290180024, 1, 'bobby124burnett@eblogging.org'),
(313, 1290180024, 1, 'voight.kevinuu0d@hotmail.com'),
(314, 1290180024, 1, 'npjenifferqip6talkington5@hotmail.com'),
(315, 1290180024, 1, 'gpwhitford.merry7@hotmail.com'),
(316, 1290180024, 1, 'seoatsem@gmail.com'),
(317, 1290180024, 1, 'tweets88@gmail.com'),
(318, 1290180024, 1, 'kenneth79travis@yahoo.co.uk'),
(319, 1290180024, 1, 'jamescconant@hotmail.com'),
(320, 1290180024, 1, 'cinncyhouses@yahoo.com'),
(321, 1290180024, 1, 'frdalilagbisbautistajf@hotmail.com'),
(322, 1290180024, 1, 'darrinmoseley78@hotmail.com'),
(323, 1290180024, 1, 'keepthefaith36@hotmail.com'),
(324, 1290180024, 1, 'chlypter@gmail.com'),
(325, 1290180024, 1, 'andiberger81@yahoo.co.uk'),
(326, 1290180024, 1, 'maretaher@gmail.com'),
(327, 1290180024, 1, 'moses2cook@yahoo.co.uk'),
(328, 1290180024, 1, 'adstricks112@gawab.com'),
(329, 1290180024, 1, 'georgelopez5478@gmx.com'),
(330, 1290180024, 1, 'xyek@freeshki.net'),
(331, 1290180024, 1, 'newtondibuebodevin@gmail.com'),
(332, 1290180024, 1, 'comp@vaver.info'),
(333, 1290180024, 1, 'noundilboli@dilatatoret-eroticat.info'),
(334, 1290180024, 1, 'logkegomeft@gmail.routedating.com'),
(335, 1290180024, 1, 'talleyneil3@gmail.com'),
(336, 1290180024, 1, 'gvs43w3@rambler.ru'),
(337, 1290180024, 1, 'lampara@freeshki.net'),
(338, 1290180024, 1, 'sensormatt@yahoo.com'),
(339, 1290180024, 1, 'harotunes@gmail.com'),
(340, 1290180024, 1, 'trittycix@msn.routedating.com'),
(341, 1290180024, 1, 'livjurnal@freeshki.net'),
(342, 1290180024, 1, 'alexlev1982@gmail.com'),
(343, 1290180024, 1, 'moskow-sun@freeshki.net'),
(344, 1290180024, 1, '21tuttavuus@gmail.com'),
(345, 1290180024, 1, 'baseall@freeshki.net'),
(346, 1290180024, 1, 'crbuy001@gmail.com'),
(347, 1290180024, 1, 'yucojykeegyfo21842@gmail.com'),
(348, 1290180024, 1, 'xanga@samenwahl.net'),
(349, 1290180024, 1, 'tradeautoland@cafreeworld.com'),
(350, 1290180024, 1, 'noundilboli@wwg-sexog-durog.info'),
(351, 1290180024, 1, 'dipoamusst@mail.ru'),
(352, 1290180024, 1, 'mutouggi@yandex.com'),
(353, 1290180024, 1, 'chinese@hotpollsite.com'),
(354, 1290180024, 1, 'janeskinner86@hotmail.com'),
(355, 1290180024, 1, 'ernestinexlrrtheisenv8g@hotmail.com'),
(356, 1290180024, 1, 'rehmanguy@yahoo.com'),
(357, 1290180024, 1, 'francisco33patel@hotmail.com'),
(358, 1290180024, 1, 'mlanersti@hotmail.com'),
(359, 1290180024, 1, 'ruddypoody@hotmail.com'),
(360, 1290180024, 1, 'russell94holmes@hotmail.com'),
(361, 1290180024, 1, 'chrisjohnson955@rediffmail.com'),
(362, 1290180024, 1, 'belladaykin@yahoo.co.uk'),
(363, 1290180024, 1, 'lawrence801hicks@myloanstips.com'),
(364, 1290180024, 1, 'lucas54mills@yahoo.co.uk'),
(365, 1290180024, 1, 'sarahbirch12@gmail.com'),
(366, 1290180024, 1, 'numnutz2005@hotmail.com'),
(367, 1290180024, 1, 'hunter94parks@yahoo.co.uk'),
(368, 1290180024, 1, 'garry73morales@yahoo.co.uk'),
(369, 1290180024, 1, 'ruputnam.manaj@hotmail.com'),
(370, 1290180024, 1, 'draclaudiaromero@yahoo.co.uk'),
(371, 1290180024, 1, 'craze_blink@yahoo.com'),
(372, 1290180024, 1, 'yanniraz@gmail.com'),
(373, 1290180024, 1, 'elly456@gmail.com'),
(374, 1290180024, 1, 'alfonso4563ramir@yahoo.co.uk'),
(375, 1290180024, 1, 'ron82bowenmoran@yahoo.co.uk'),
(376, 1290180024, 1, 'firepenas@gmail.com'),
(377, 1290180024, 1, 'junkblogmaster@gmail.com'),
(378, 1290180024, 1, 'reena6yxobirdwellfxg@hotmail.com'),
(379, 1290180024, 1, 'atkinsrecipesinfo01@gmail.com'),
(380, 1290180024, 1, 'flooring@diy-seo.info'),
(381, 1290180024, 1, 'andy7kane@yahoo.co.uk'),
(382, 1290180024, 1, 'jeremy5wade@yahoo.co.uk'),
(383, 1290180024, 1, 'young7barnett@yahoo.co.uk'),
(384, 1290180024, 1, 'randy6rowe@yahoo.co.uk'),
(385, 1290180024, 1, 'marcolaoregon@gmail.com'),
(386, 1290180024, 1, 'shiela.hoeyyuum@hotmail.com'),
(387, 1290180024, 1, 'cocokakaz@gmail.com'),
(388, 1290180024, 1, 'shawnwulff85@hotmail.com'),
(389, 1290180024, 1, 'mardellzfbwweatherlyxso@hotmail.com'),
(390, 1290180024, 1, 'antoncarpenter73@yahoo.co.uk'),
(391, 1290180024, 1, 'rrarela@gmail.com'),
(392, 1290180024, 1, 'lirianomary@ymail.com'),
(393, 1290180024, 1, 'swingerkd@hotmail.com'),
(394, 1290180024, 1, 'free8tattoo@yahoo.co.uk'),
(395, 1290180024, 1, 'robert74shelton@yahoo.co.uk'),
(396, 1290180024, 1, 'rigoberto2terrel@hotmail.com'),
(397, 1290180024, 1, 'sergio65gordon@yahoo.co.uk'),
(398, 1290180024, 1, 'sebastian3lamber@yahoo.co.uk'),
(399, 1290180024, 1, 'reganssame@hotmail.com'),
(400, 1290180024, 1, 'shaun65hodge@yahoo.co.uk'),
(401, 1290180024, 1, 'willardmurphy81@hotmail.com'),
(402, 1290180024, 1, 'mohsintal@yahoo.com'),
(403, 1290180024, 1, 'goteborg12345@yahoo.co.uk'),
(404, 1290180024, 1, 'choyie.robby@yahoo.com'),
(405, 1290180024, 1, 'aileaatacads@yahoo.com'),
(406, 1290180024, 1, 'ortiz.ryan93@yahoo.com'),
(407, 1290180024, 1, 'traveliron18@yahoo.co.uk'),
(408, 1290180024, 1, 'esthetiquemaroc@cliniqueesthetique-guessous.com'),
(409, 1290180024, 1, 'daren18frazier@yahoo.co.uk'),
(410, 1290180024, 1, 'ga2vin82da1nga@yahoo.co.uk'),
(411, 1290180024, 1, 'alvairaaljaijohn@yahoo.com'),
(412, 1290180024, 1, 'jawadrathore10@yahoo.com'),
(413, 1290180024, 1, 'baast879@gmail.com'),
(414, 1290180024, 1, 'goupil@kliometrie.de'),
(415, 1290180024, 1, 'implantdentist33@yahoo.co.uk'),
(416, 1290180024, 1, 'lautogas@yahoo.com'),
(417, 1290180024, 1, 'timmy69bishop@yahoo.co.uk'),
(418, 1290180024, 1, 'belenevansrr16514@yahoo.com'),
(419, 1290180024, 1, 'queen-eight@hotmail.com'),
(420, 1290180024, 1, 'elsdonwyston@yahoo.com'),
(421, 1290180024, 1, 'mike45gates@hotmail.com'),
(422, 1290180024, 1, 'grosszeniavoygn@hotmail.com'),
(423, 1290180024, 1, 'mastercbpromo@gmail.com'),
(424, 1290180024, 1, 'gussiemeppee@hotmail.com'),
(425, 1290180024, 1, 'marcus91ray@yahoo.co.uk'),
(426, 1290180024, 1, 'ted69weiss@yahoo.co.uk'),
(427, 1290180024, 1, 'lamonica.mayawbi@hotmail.com'),
(428, 1290180024, 1, 'simon12dorsey@yahoo.co.uk'),
(429, 1290180024, 1, 'pwsslick@gmail.com'),
(430, 1290180024, 1, 'cucpantherainn@hotmail.com'),
(431, 1290180024, 1, 'ashleycervantes6@yahoo.co.uk'),
(432, 1290180024, 1, 'deferneptl9ybarrayg@hotmail.com'),
(433, 1290180024, 1, 'magalufhotels10@hotmail.com'),
(434, 1290180024, 1, 'tim63lane@yahoo.co.uk'),
(435, 1290180024, 1, 'copymysignal@gmail.com'),
(436, 1290180024, 1, 'dtorton@aol.de'),
(437, 1290180024, 1, 'derhammer211@arcor.de'),
(438, 1290180024, 1, 'legalmoviesites@yahoo.co.uk'),
(439, 1290180024, 1, 'stuartkaufmanbiz@yahoo.co.uk'),
(440, 1290180024, 1, 'ossvaldostasa@yahoo.co.uk'),
(441, 1290180024, 1, 'wlunsford03@gmail.com'),
(442, 1290180024, 1, 'hayekdnac@hotmail.com'),
(443, 1290180024, 1, 'darrel77hester@yahoo.co.uk'),
(444, 1290180024, 1, 'a.meldrum@yahoo.com'),
(445, 1290180024, 1, 'herman41wagner@yahoo.co.uk'),
(446, 1290180024, 1, 'conrad29henderso@yahoo.co.uk'),
(447, 1290180024, 1, 'david.choi34@yahoo.com'),
(448, 1290180024, 1, 'urmilavilencia@ymail.com'),
(449, 1290180024, 1, 'jamesgriff1@yahoo.co.uk'),
(450, 1290180024, 1, 'alfredseaborn83@hotmail.com'),
(451, 1290180024, 1, 'cbertholdeval@hotmail.com'),
(452, 1290180024, 1, 'freemanwheeler8@gmail.com'),
(453, 1290180024, 1, 'nlenorabatt@hotmail.com'),
(454, 1290180024, 1, 'nerssmokeless@yahoo.co.uk'),
(455, 1290180024, 1, 'cristenjomec@hotmail.com'),
(456, 1290180024, 1, 'les459ramsey@yahoo.co.uk'),
(457, 1290180024, 1, 'kent81kerr@yahoo.co.uk'),
(458, 1290180024, 1, 'mezitli190545@yahoo.co.uk'),
(459, 1290180024, 1, 'micheal_leek@yahoo.com'),
(460, 1290180024, 1, 'cxush37777@yahoo.co.uk'),
(461, 1290180024, 1, 'help@backlinkevolution.com'),
(462, 1290180024, 1, 'barton8emerson@yahoo.co.uk'),
(463, 1290180024, 1, 'shrodegaunie@hotmail.com'),
(464, 1290180024, 1, 'disneyg01@yahoo.com'),
(465, 1290180024, 1, 'johnnyconley84@aol.com'),
(466, 1290180024, 1, 'condaunuae@gmail.com'),
(467, 1290180024, 1, 'harold.harold22@yahoo.com'),
(468, 1290180024, 1, 'edmond42dillard@yahoo.co.uk'),
(469, 1290180024, 1, 'dorabootex@gmail.com'),
(470, 1290180024, 1, 'no1guitars2buy@yahoo.co.uk'),
(471, 1290180024, 1, 'milenko_sr@hotmail.com'),
(472, 1290180024, 1, 'hhrvdsuu731@gmail.com'),
(473, 1290180024, 1, 'poqenf@gmail.com'),
(474, 1290180024, 1, 'darcylhame@hotmail.com'),
(475, 1290180024, 1, 'jayg17804@gmail.com'),
(476, 1290180024, 1, 'intermarketingsi@yahoo.co.uk'),
(477, 1290180024, 1, 'ron6moran@yahoo.co.uk'),
(478, 1290180024, 1, 'ntakeuchilest@hotmail.com'),
(479, 1290180024, 1, 'merlin11bates@railmail.net'),
(480, 1290180024, 1, 'andrewmilligan78@hotmail.com'),
(481, 1290180024, 1, 'wyatt8mclaughlin@yahoo.co.uk'),
(482, 1290180024, 1, 'bradley22gilmore@yahoo.co.uk'),
(483, 1290180024, 1, 'aroomark@yahoo.com'),
(484, 1290180024, 1, 'mark.hurd1000@yahoo.com'),
(485, 1290180024, 1, 'chrisadam301@gmail.com'),
(486, 1290180024, 1, 'slaughter.haas@yahoo.com'),
(487, 1290180024, 1, 'patjeremy79@gmail.com'),
(488, 1290180024, 1, 'sultangebet@pialaduniaonline.co.cc'),
(489, 1290180024, 1, 'de4hive0more@yahoo.co.uk'),
(490, 1290180024, 1, 'ruben84palmer@yahoo.co.uk'),
(491, 1290180024, 1, 'pilu2511@zing.vn'),
(492, 1290180024, 1, 'wiidiscounter@gmail.com'),
(493, 1290180024, 1, 'hira977@yahoo.com'),
(494, 1290180024, 1, 'elliott26fuentes@yahoo.co.uk'),
(495, 1290180024, 1, 'takingback68@yahoo.com'),
(496, 1290180024, 1, 'stevensonlamuel8@hotmail.com'),
(497, 1290180024, 1, 'roland52valencia@yahoo.co.uk'),
(498, 1290180024, 1, 'jamiehilovsky233262@hotmail.com'),
(499, 1290180024, 1, 'hung71charles@yahoo.co.uk'),
(500, 1290180024, 1, 'carlitamckdim@hotmail.com'),
(501, 1290180024, 1, 'brooks95lindsey@yahoo.co.uk'),
(502, 1290180024, 1, 'brooks95lindsey@yahoo.co.uk'),
(503, 1290180024, 1, 'duane22reid@yahoo.co.uk'),
(504, 1290180024, 1, 'cherie_annlim@yahoo.com'),
(505, 1290180024, 1, 'fira19hanes@gmail.com'),
(506, 1290180024, 1, 'bunyardhaklagr@hotmail.com'),
(507, 1290180024, 1, 'matthew49downs@hotmail.com'),
(508, 1290180024, 1, 'yolandazsanchez@gmail.com'),
(509, 1290180024, 1, 'vivianadgarez@hotmail.com'),
(510, 1290180024, 1, 'darlenabirele@hotmail.com'),
(511, 1290180024, 1, 'oolindahlak@hotmail.com'),
(512, 1290180024, 1, 'stevegg66@hotmail.co.uk'),
(513, 1290180024, 1, 'brain2cole@yahoo.co.uk'),
(514, 1290180024, 1, 'myron7weiss@yahoo.co.uk'),
(515, 1290180024, 1, 'fmcgauleyrle@hotmail.com'),
(516, 1290180024, 1, 'delbert77hinton@yahoo.co.uk'),
(517, 1290180024, 1, 'owen94ruiz@hotmail.com'),
(518, 1290180024, 1, 'desmoundweljec@hotmail.com'),
(519, 1290180024, 1, 'sparrow.fly@hotmail.com'),
(520, 1290180024, 1, 'alan8grant@yahoo.co.uk'),
(521, 1290180024, 1, 'lisabeckerbeckt@gmail.com'),
(522, 1290180024, 1, 'gil58petersen@yahoo.co.uk'),
(523, 1290180024, 1, 'choppertattoox2@yahoo.co.uk'),
(524, 1290180024, 1, 'elmer254decker@myloanstips.com'),
(525, 1290180024, 1, 'leonard53sawyer@yahoo.co.uk'),
(526, 1290180024, 1, 'benny8rivas@yahoo.co.uk'),
(527, 1290180024, 1, 'showerstehe@hotmail.com'),
(528, 1290180024, 1, 'glen18s@hotmail.com'),
(529, 1290180024, 1, 'latshawmicmps@hotmail.com'),
(530, 1290180024, 1, 'lillyjohns@juicycouturecharms.com'),
(531, 1290180024, 1, 'velvamrhe@hotmail.com'),
(532, 1290180024, 1, 'maynard9zamora@yahoo.co.uk'),
(533, 1290180024, 1, 'collettedelve@hotmail.com'),
(534, 1290180024, 1, 'morrisbarbour85@hotmail.com'),
(535, 1290180024, 1, 'whoopiballenow@gmail.com'),
(536, 1290180024, 1, 'oglesvictogetru@hotmail.com'),
(537, 1290180024, 1, 'octavianoconnor@ymail.com'),
(538, 1290180024, 1, 'geraldcargill85@businesstutor.org'),
(539, 1290180024, 1, 'bostonmarketguyz@yahoo.co.uk'),
(540, 1290180024, 1, 'lindsey7mullen@yahoo.co.uk'),
(541, 1290180024, 1, 'ali55kline@yahoo.co.uk'),
(542, 1290180024, 1, 'owen18compton@yahoo.co.uk'),
(543, 1290180024, 1, 'perrybayne83@hotmail.com'),
(544, 1290180024, 1, 'drumanjelikri@hotmail.com'),
(545, 1290180024, 1, 'www_userid@yahoo.com'),
(546, 1290180024, 1, 'ivory5long@yahoo.co.uk'),
(547, 1290180024, 1, 'ashley14bradshaw@yahoo.co.uk'),
(548, 1290180024, 1, 'fechterkhok@hotmail.com'),
(549, 1290180024, 1, 'himmlerjames@gmail.com'),
(550, 1290180024, 1, 'lebronjames_06miami@yahoo.com'),
(551, 1290180024, 1, 'federicstonemi99@yahoo.co.uk'),
(552, 1290180024, 1, 'jesus83dominguez@hotmail.com'),
(553, 1290180024, 1, 'blackxp101@yahoo.co.uk'),
(554, 1290180024, 1, 'deschainejttal@hotmail.com'),
(555, 1290180024, 1, 'vincent44murray@yahoo.co.uk'),
(556, 1290180024, 1, 'sheunlvose@hotmail.com'),
(557, 1290180024, 1, 'arthur11brady@yahoo.co.uk'),
(558, 1290180024, 1, 'jeffreyhulbert81@hotmail.com'),
(559, 1290180024, 1, 'kenny13maldonado@yahoo.co.uk'),
(560, 1290180024, 1, 'gerald8simpson@yahoo.co.uk'),
(561, 1290180024, 1, 'nelsongentry1977@yahoo.co.uk'),
(562, 1290180024, 1, 'johnnie73mcmahon@yahoo.co.uk'),
(563, 1290180024, 1, 'adstricks112@gawab.com'),
(564, 1290180024, 1, 'matthesmoriete@hotmail.com'),
(565, 1290180024, 1, 'dleighelali@hotmail.com'),
(566, 1290180024, 1, 'drivinggames1@gmail.com'),
(567, 1290180024, 1, 'links143@hotmail.com'),
(568, 1290180024, 1, 'strong88guys@yahoo.co.uk'),
(569, 1290180024, 1, 'jaime91bartlett@yahoo.co.uk'),
(570, 1290180024, 1, 'emmanuel51cooley@yahoo.co.uk'),
(571, 1290180024, 1, 'chuck67church@yahoo.co.uk'),
(572, 1290180024, 1, 'emmanuel51cooley@yahoo.co.uk'),
(573, 1290180024, 1, 'derek.phil1@live.com'),
(574, 1290180024, 1, 'glenvincent82@hotmail.com'),
(575, 1290180024, 1, 'alberto16moss@googlemail.com'),
(576, 1290180024, 1, 'stefanwild1958@yahoo.co.uk'),
(577, 1290180024, 1, 'bobbie8kaju@yahoo.co.uk'),
(578, 1290180024, 1, 'emery1wise@yahoo.co.uk'),
(579, 1290180024, 1, 'laverne26rodgers@yahoo.co.uk'),
(580, 1290180024, 1, 'dhoutlet10@gmail.com'),
(581, 1290180024, 1, 'abase013@gmail.com'),
(582, 1290180024, 1, 'pavery3warnerx@maxiemail.com'),
(583, 1290180024, 1, 'edz.bacagan@yahoo.com'),
(584, 1290180024, 1, 'dwhiting007@gmail.com'),
(585, 1290180024, 1, 'petronilaovermann15@hotmail.com'),
(586, 1290180024, 1, 'jimenabrienantwan@gmail.com'),
(587, 1290180024, 1, 'yukicichocrnax@hotmail.com'),
(588, 1290180024, 1, 'weirichlanamow@hotmail.com'),
(589, 1290180024, 1, 'kaizen1site@gmail.com'),
(590, 1290180024, 1, 'alfonso72monroe@hotmail.com'),
(591, 1290180024, 1, 'dexters7mendoza@yahoo.co.uk'),
(592, 1290180024, 1, 'amanamicrowave12@yahoo.co.uk'),
(593, 1290180024, 1, 'sylvester3huffma@yahoo.co.uk'),
(594, 1290180024, 1, 'chase67burks@yahoo.co.uk'),
(595, 1290180024, 1, 'jacqupacchi23@yahoo.com'),
(596, 1290180024, 1, 'evalcarceliant@hotmail.com'),
(597, 1290180024, 1, 'georgecohan2010@gmail.com'),
(598, 1290180024, 1, 'kennethpoynter1@yahoo.co.uk'),
(599, 1290180024, 1, 'gavin36pollard@yahoo.co.uk'),
(600, 1290180024, 1, 'mary38sykes@yahoo.co.uk'),
(601, 1290180024, 1, 'morgan6lambert@yahoo.co.uk'),
(602, 1290180024, 1, 'joan73bonner@hotmail.com'),
(603, 1290180024, 1, 'keving@mortgagescottsdaleaz.com'),
(604, 1290180024, 1, 'chad49herrera@hotmail.com'),
(605, 1290180024, 1, 'rardondird@hotmail.com'),
(606, 1290180024, 1, 'edgarcayce1000@yahoo.com'),
(607, 1290180024, 1, 'facebookadder@hotmail.com'),
(608, 1290180024, 1, 'georgemchugh83@hotmail.com'),
(609, 1290180024, 1, 'darrell2matthews@yahoo.co.uk'),
(610, 1290180024, 1, 'nathan35watts@yahoo.co.uk'),
(611, 1290180024, 1, 'michel92york@yahoo.co.uk'),
(612, 1290180024, 1, 'buman@newaysonline.tv'),
(613, 1290180024, 1, 'dean17strickland@yahoo.co.uk'),
(614, 1290180024, 1, 'mcerrudo7@gmail.com'),
(615, 1290180024, 1, 'stacey89workman@yahoo.co.uk'),
(616, 1290180024, 1, 'a_ahman@yahoo.com'),
(617, 1290180024, 1, 'melinamoore373@yahoo.com'),
(618, 1290180024, 1, 'esteeruiz@gmail.com'),
(619, 1290180024, 1, 'craig@secondpad.com'),
(620, 1290180024, 1, 'michellediaz1216@yahoo.com'),
(621, 1290180024, 1, 'ramon11carter@hotmail.com'),
(622, 1290180024, 1, 'lhibbittsebeik@hotmail.com'),
(623, 1290180024, 1, 'gil19roberts@hotmail.com'),
(624, 1290180024, 1, 'luekelsielomm@hotmail.com'),
(625, 1290180024, 1, 'villagetransportation@gmail.com'),
(626, 1290180024, 1, 'karr56997@yahoo.co.uk'),
(627, 1290180024, 1, 'hal@forcetronix.com'),
(628, 1290180024, 1, 'kathlynmrtet@hotmail.com'),
(629, 1290180024, 1, 'timothy19721love@hotmail.com'),
(630, 1290180024, 1, 'virenaccas@hotmail.com'),
(631, 1290180024, 1, 'jese2sie54dumuc@yahoo.co.uk'),
(632, 1290180024, 1, 'glockrtol@hotmail.com'),
(633, 1290180024, 1, 'markhurd1000@yahoo.com'),
(634, 1290180024, 1, 'maurinetnna@hotmail.com'),
(635, 1290180024, 1, 'dansayereco@hotmail.com'),
(636, 1290180024, 1, 'belenevansbb16511@yahoo.com'),
(637, 1290180024, 1, 'donny43colon@yahoo.co.uk'),
(638, 1290180024, 1, 'jalynmitchellii16526@yahoo.com'),
(639, 1290180024, 1, 'alvin39caruso@hotmail.com'),
(640, 1290180024, 1, 'backlinksarebest@gmail.com'),
(641, 1290180024, 1, 'miltongallegos82@yahoo.co.uk'),
(642, 1290180024, 1, 'a_barcoma@yahoo.com'),
(643, 1290180024, 1, 'ryan76mccormick@yahoo.co.uk'),
(644, 1290180024, 1, 'judifarmer22@gmail.com'),
(645, 1290180024, 1, 'clinton58nixon@yahoo.co.uk'),
(646, 1290180024, 1, 'sparkletsirni@hotmail.com'),
(647, 1290180024, 1, 'raviram1973@yahoo.com'),
(648, 1290180024, 1, 'cyoulandadavod@hotmail.com'),
(649, 1290180024, 1, 'v5+10@mymailindex.com'),
(650, 1290180024, 1, 'tim33schroeder@yahoo.co.uk'),
(651, 1290180024, 1, 'jkintons@gmail.com'),
(652, 1290180024, 1, 'jarvis77paul@yahoo.co.uk'),
(653, 1290180024, 1, 'elbert6reid@yahoo.co.uk'),
(654, 1290180024, 1, 'joseph29pope@yahoo.co.uk'),
(655, 1290180024, 1, 'alden4collins@yahoo.co.uk'),
(656, 1290180024, 1, 'freemankirklan78@yahoo.co.uk'),
(657, 1290180024, 1, 'anoop.ettan@yahoo.com'),
(658, 1290180024, 1, 'cyril6harrington@yahoo.co.uk'),
(659, 1290180024, 1, 'jerrod1gray@yahoo.co.uk'),
(660, 1290180024, 1, 'randolphmason201@hotmail.com'),
(661, 1290180024, 1, 'jarvisprestonttk@yahoo.co.uk'),
(662, 1290180024, 1, 'lavalampsforsalenow@gmail.com'),
(663, 1290180024, 1, 'daveracer@live.com'),
(664, 1290180024, 1, 'hunvaldtottis@gmail.com'),
(665, 1290180024, 1, 'pmabonuttas@hotmail.com'),
(666, 1290180024, 1, 'dalesteyn222@gmail.com'),
(667, 1290180024, 1, 'deli8ibos@yahoo.co.uk'),
(668, 1290180024, 1, 'snydershanrteti@hotmail.com'),
(669, 1290180024, 1, 'winonasteluprac@hotmail.com'),
(670, 1290180024, 1, 'stevecakko@hotmail.com'),
(671, 1290180024, 1, 'ted56oliver@yahoo.co.uk'),
(672, 1290180024, 1, 'hotell72resorna@hotmail.com'),
(673, 1290180024, 1, 'hcathyntzis@hotmail.com'),
(674, 1290180024, 1, 'marvaalle@hotmail.com'),
(675, 1290180024, 1, 'teddy79chaney@yahoo.co.uk'),
(676, 1290180024, 1, 'wbrackett50@yahoo.com'),
(677, 1290180024, 1, 'mskerrittelaup@hotmail.com'),
(678, 1290180024, 1, 'ernesto77anthony@yahoo.co.uk'),
(679, 1290180024, 1, 'oilzapper@yahoo.in'),
(680, 1290180024, 1, 'johnjohncina@yahoo.com'),
(681, 1290180024, 1, 'axprovn@gmail.com'),
(682, 1290180024, 1, 'jonathan9wooten@yahoo.co.uk'),
(683, 1290180024, 1, 'jjjsmitha@gmail.com'),
(684, 1290180024, 1, 'fsmithys35@gmail.com'),
(685, 1290180024, 1, 'sethwhitaker252@gmail.com'),
(686, 1290180024, 1, 'moniqueherschel674@gmail.com'),
(687, 1290180024, 1, 'wilmer9snyder999@yahoo.co.uk'),
(688, 1290180024, 1, 'juan49frank@yahoo.co.uk'),
(689, 1290180024, 1, 'booker69melendez@yahoo.co.uk'),
(690, 1290180024, 1, 'jamescanning84@hotmail.com'),
(691, 1290180024, 1, 'karonbispo@hotmail.com'),
(692, 1290180024, 1, 'donnie71wood@yahoo.co.uk'),
(693, 1290180024, 1, 'fusiondesignagency@gmail.com'),
(694, 1290180024, 1, 'julia62conley@gmail.com'),
(695, 1290180024, 1, 'tonydeg2@hotmail.com'),
(696, 1290180024, 1, 'billigerparken@ymail.com'),
(697, 1290180024, 1, 'houston21zimmerm@yahoo.co.uk'),
(698, 1290180024, 1, 'kristalamen@hotmail.com'),
(699, 1290180024, 1, 'lovinsocal80@gmail.com'),
(700, 1290180024, 1, 'parkenmunchenflughafen@yahoo.com'),
(701, 1290180024, 1, 'warzeffa@gmail.com'),
(702, 1290180024, 1, 'billigerflughafen@ymail.com'),
(703, 1290180024, 1, 'myungferebsar@hotmail.com'),
(704, 1290180024, 1, 'towersdefense@gmail.com'),
(705, 1290180024, 1, 'edgarcayce1000@yahoo.com'),
(706, 1290180024, 1, 'jamesvbxm87@yahoo.co.uk'),
(707, 1290180024, 1, 'merlin3cooke@yahoo.co.uk'),
(708, 1290180024, 1, 'glen6day@yahoo.co.uk'),
(709, 1290180024, 1, 'flughafenparken@yahoo.com'),
(710, 1290180024, 1, 'dante6miranda@yahoo.co.uk'),
(711, 1290180024, 1, 'ledlichtwerbung@hotmail.com'),
(712, 1290180024, 1, 'timberland8shoes@yahoo.co.uk'),
(713, 1290180024, 1, 'kirk76middleton@yahoo.co.uk'),
(714, 1290180024, 1, 'luxurytraveljc@googlemail.com'),
(715, 1290180024, 1, 'moduleefficiency@yahoo.com'),
(716, 1290180024, 1, 'brianyost810@yahoo.com'),
(717, 1290180024, 1, 'reinaldophelps23@yahoo.co.uk'),
(718, 1290180024, 1, 'wasserstrahl@hotmail.com'),
(719, 1290180024, 1, 'gary52diaz@yahoo.co.uk'),
(720, 1290180024, 1, 'pwhitt1966@gmail.com'),
(721, 1290180024, 1, 'olivergrames83@hotmail.com'),
(722, 1290180024, 1, 'johnny6pate@aol.com'),
(723, 1290180024, 1, 'buddy9rowe@hotmail.com'),
(724, 1290180024, 1, 'myannapa@hotmail.com'),
(725, 1290180024, 1, 'creative.mind09@yahoo.com'),
(726, 1290180024, 1, 'rory21armstrong@yahoo.co.uk'),
(727, 1290180024, 1, 'success1927@hotmail.com'),
(728, 1290180024, 1, 'annaleeegeleigmw@hotmail.com'),
(729, 1290180024, 1, 'roman79moody@yahoo.co.uk'),
(730, 1290180024, 1, 'gregory21klein@yahoo.co.uk'),
(731, 1290180024, 1, 'luise3patterson@aol.com'),
(732, 1290180024, 1, 'johnnie5herberts@yahoo.co.uk'),
(733, 1290180024, 1, 'ellis65welch@yahoo.co.uk'),
(734, 1290180024, 1, 'luise3patterson@aol.com'),
(735, 1290180024, 1, 'hufster10@hotmail.com'),
(736, 1290180024, 1, 'pphotovoltaic@yahoo.com'),
(737, 1290180024, 1, 'patrick36french@yahoo.co.uk'),
(738, 1290180024, 1, 'irwin77howe@yahoo.co.uk'),
(739, 1290180024, 1, 'sidneylammi@gmail.com'),
(740, 1290180024, 1, 'alexabrookman@gmail.com'),
(741, 1290180024, 1, 'mkesparebh@hotmail.com'),
(742, 1290180024, 1, 'mindy8710@yahoo.com'),
(743, 1290180024, 1, 'dorrisott82@gmail.com'),
(744, 1290180024, 1, 'phillipolunay@yahoo.co.uk'),
(745, 1290180024, 1, 'eddyjabre@hotmail.com'),
(746, 1290180024, 1, 'despinao6jungen@yahoo.co.uk'),
(747, 1290180024, 1, 'allnaturalcleani@yahoo.co.uk'),
(748, 1290180024, 1, 'tuni3buzz@yahoo.co.uk'),
(749, 1290180024, 1, 'robsontomphson47@yahoo.co.uk'),
(750, 1290180024, 1, 'naturalsleepaid@gmail.com'),
(751, 1290180024, 1, 'citizenautofinance@gmail.com'),
(752, 1290180024, 1, 'belsmokeless@yahoo.co.uk'),
(753, 1290180024, 1, 'tenniehenkize@hotmail.com'),
(754, 1290180024, 1, 'alviarsrnsad@hotmail.com'),
(755, 1290180024, 1, 'andres82marshall@yahoo.co.uk'),
(756, 1290180024, 1, 'pouzee2511@gmail.com'),
(757, 1290180024, 1, 'kond@myaurorachiropractic.com'),
(758, 1290180024, 1, 'shannon82ross@36ru.com'),
(759, 1290180024, 1, 'gibeauashling@hotmail.com'),
(760, 1290180024, 1, 'emmett55whitley@hotmail.com'),
(761, 1290180024, 1, 'billythorton3572@gmail.com'),
(762, 1290180024, 1, 'dion9potts92@yahoo.com'),
(763, 1290180024, 1, 'toaccess@sogou.com'),
(764, 1290180024, 1, 'ru4@myaurorachiropractic.com'),
(765, 1290180024, 1, 'winbergsherarag@hotmail.com'),
(766, 1290180024, 1, 'ervin42stafford@yahoo.co.uk'),
(767, 1290180024, 1, 'willis2ellis@aol.com'),
(768, 1290180024, 1, 'sixtrent@hotmail.com'),
(769, 1290180024, 1, 'jorgeclam12@aol.com'),
(770, 1290180024, 1, 'kelsiegraycefountain@gmail.com'),
(771, 1290180024, 1, 'sexxiebebe23net@yahoo.co.uk'),
(772, 1290180024, 1, 'liosmuscles@yahoo.co.uk'),
(773, 1290180024, 1, 'seo@miadeo.com'),
(774, 1290180024, 1, 'everette71walker@yahoo.co.uk'),
(775, 1290180024, 1, 'moonmaria94@yahoo.com'),
(776, 1290180024, 1, 'debtrelief1912@hotmail.com'),
(777, 1290180024, 1, 'reed75gregory@yahoo.co.uk'),
(778, 1290180024, 1, 'nikhil.walker@hotmail.com'),
(779, 1290180024, 1, 'galett11gill@hotmail.com'),
(780, 1290180024, 1, 'r.lijkwan@yahoo.com'),
(781, 1290180024, 1, 'phillip19fuentes@yahoo.co.uk'),
(782, 1290180024, 1, 'vince74clements@yahoo.co.uk'),
(783, 1290180024, 1, 'stiefsidsa@hotmail.com'),
(784, 1290180024, 1, 'lspielbergagam@hotmail.com'),
(785, 1290180024, 1, 'kasiackrit@hotmail.com'),
(786, 1290180024, 1, 'susangray92@travelad.org'),
(787, 1290180024, 1, 'milawakorvz@myaurorachiropractic.co'),
(788, 1290180024, 1, 'hppmn4@gmail.com'),
(789, 1290180024, 1, 'lostcrafts@hotmail.com'),
(790, 1290180024, 1, 'ingridtlell@hotmail.com'),
(791, 1290180024, 1, 'jodiwitherspolk@yahoo.co.uk'),
(792, 1290180024, 1, 'benpri@myanchoragechiropractor.com'),
(793, 1290180024, 1, 'edgar23reed@yahoo.co.uk'),
(794, 1290180024, 1, 'errol86baldwin@yahoo.co.uk'),
(795, 1290180024, 1, 'asaynute@hotmail.com'),
(796, 1290180024, 1, 'jonathon36howe@aol.com'),
(797, 1290180024, 1, 'belabron@yahoo.com'),
(798, 1290180024, 1, 'jacaboram@hotmail.com'),
(799, 1290180024, 1, 'angelgomez143@gmail.com'),
(800, 1290180024, 1, 'charlie66up@gmail.com'),
(801, 1290180024, 1, 'percy25day@yahoo.co.uk'),
(802, 1290180024, 1, 'lisawillinga25@yahoo.com'),
(803, 1290180024, 1, 'h2rsh4l8ad1ms@aol.com'),
(804, 1290180024, 1, 'miles15cole@yahoo.co.uk'),
(805, 1290180024, 1, 'morton48phillips@yahoo.co.uk'),
(806, 1290180024, 1, 'websitetrafficpumper@gmail.com'),
(807, 1290180024, 1, 'tammy.hisey@yahoo.com'),
(808, 1290180024, 1, 'pwhitt1966@gmail.com'),
(809, 1290180024, 1, 'toby57rowland@yahoo.co.uk'),
(810, 1290180024, 1, 'simon57britt@yahoo.co.uk'),
(811, 1290180024, 1, 'jackie14gray@yahoo.co.uk'),
(812, 1290180024, 1, 'ariel65lindsey@yahoo.co.uk'),
(813, 1290180024, 1, 'kathleenbuilme@hotmail.com'),
(814, 1290180024, 1, 'cluongeli@hotmail.com'),
(815, 1290180024, 1, 'wilfredo3tillman@yahoo.co.uk'),
(816, 1290180024, 1, 'walter57burks@yahoo.co.uk'),
(817, 1290180024, 1, 'leonaxittel@hotmail.com'),
(818, 1290180024, 1, 'jefferson56pruit@yahoo.co.uk'),
(819, 1290180024, 1, 'violetadorahir@hotmail.com'),
(820, 1290180024, 1, 'cwoltmanansi@hotmail.com'),
(821, 1290180024, 1, 'deleelaronnochu@hotmail.com'),
(822, 1290180024, 1, 'abadon41@yahoo.com'),
(823, 1290180024, 1, 'irwin49best@yahoo.co.uk'),
(824, 1290180024, 1, 'hobokenforeclosu@yahoo.co.uk'),
(825, 1290180024, 1, 'ben1@myanchoragechiropractor.com'),
(826, 1290180024, 1, 'okmallorcaer@hotmail.com'),
(827, 1290180024, 1, 'senahalko@gmail.com'),
(828, 1290180024, 1, 'alejandro29coole@yahoo.co.uk'),
(829, 1290180024, 1, 'maryannaldrue@hotmail.com'),
(830, 1290180024, 1, 'melanyerichmurphy@gmail.com'),
(831, 1290180024, 1, 'kirby93dominguez@yahoo.co.uk'),
(832, 1290180024, 1, 'mondayweb20@gmail.com'),
(833, 1290180024, 1, 'tobymack9561@yahoo.co.uk'),
(834, 1290180024, 1, 'vdornfeldazed@hotmail.com'),
(835, 1290180024, 1, 'yolandazsanchez@gmail.com'),
(836, 1290180024, 1, 'thecolorcontactsblog@yahoo.fr'),
(837, 1290180024, 1, 'gushowe723@yahoo.co.uk'),
(838, 1290180024, 1, 'ernest32mckenzie@yahoo.co.uk'),
(839, 1290180024, 1, 'milesvaughni@yahoo.co.uk'),
(840, 1290180024, 1, 'homer56greer@hotmail.com'),
(841, 1290180024, 1, 'versicherungen44@yahoo.co.uk'),
(842, 1290180024, 1, 'jordan51baxter2@hotmail.com'),
(843, 1290180024, 1, 'kenmathie89@yahoo.co.uk'),
(844, 1290180024, 1, 'malliemucczen@hotmail.com'),
(845, 1290180024, 1, 'devin17pierce@yahoo.co.uk'),
(846, 1290180024, 1, 'angelinereimer@yahoo.com'),
(847, 1290180024, 1, 'dickeortac@hotmail.com'),
(848, 1290180024, 1, 'wallace92tillman@yahoo.com'),
(849, 1290180024, 1, 'tienhenrynort@hotmail.com'),
(850, 1290180024, 1, 'edienthuen@hotmail.com'),
(851, 1290180024, 1, 'mcleodjoe58@gmail.com'),
(852, 1290180024, 1, 'wordpresstemplat@yahoo.co.uk'),
(853, 1290180024, 1, 'catinagrosckasi@hotmail.com'),
(854, 1290180024, 1, 'hothappyjed@hotmail.com'),
(855, 1290180024, 1, 'info@greenrevolutioninindia.com'),
(856, 1290180024, 1, 'irvin93cline@yahoo.co.uk'),
(857, 1290180024, 1, '1291466610@qq.com'),
(858, 1290180024, 1, 'marvindishman78@yahoo.co.uk'),
(859, 1290180024, 1, 'superconecs@yahoo.co.uk'),
(860, 1290180024, 1, 'ru1@myaurorachiropractic.com'),
(861, 1290180024, 1, 'deboradoiricie@hotmail.com'),
(862, 1290180024, 1, 'balderaslbru@hotmail.com'),
(863, 1290180024, 1, 'calvin74langley@yahoo.co.uk'),
(864, 1290180024, 1, 'hiram88cabrera@yahoo.co.uk'),
(865, 1290180024, 1, 'haydelakau@hotmail.com'),
(866, 1290180024, 1, 'strojnyjllfer@hotmail.com'),
(867, 1290180024, 1, 'easyinternetmarketer@gmail.com'),
(868, 1290180024, 1, 'tr7radio@gmail.com'),
(869, 1290180024, 1, 'roccoadkinssz3@yahoo.co.uk'),
(870, 1290180024, 1, 'bielymerlemasm@hotmail.com'),
(871, 1290180024, 1, 'critetrdepe@hotmail.com'),
(872, 1290180024, 1, 'regionalpilotjobs@yahoo.com'),
(873, 1290180024, 1, 'charlescase82@hotmail.com'),
(874, 1290180024, 1, 'wm27crawford@yahoo.co.uk'),
(875, 1290180024, 1, 'tayabsiddique@yahoo.com'),
(876, 1290180024, 1, 'armando11hull@yahoo.co.uk'),
(877, 1290180024, 1, 'mellanyb16@yahoo.com'),
(878, 1290180024, 1, 'darrylross46@yahoo.co.uk'),
(879, 1290180024, 1, 'harvey59rojas@yahoo.co.uk'),
(880, 1290180024, 1, 'scot85paulson@yahoo.co.uk'),
(881, 1290180024, 1, 'wilfredo21tillma@yahoo.co.uk'),
(882, 1290180024, 1, 'i2010q@gmail.com'),
(883, 1290180024, 1, 'harrbell2002@gmail.com'),
(884, 1290180024, 1, 'edebtsettlementcompany@gmail.com'),
(885, 1290180024, 1, 'nelson68gentry@yahoo.co.uk'),
(886, 1290180024, 1, 'amartenans@hotmail.com'),
(887, 1290180024, 1, 'ariel49guthrie@yahoo.co.uk'),
(888, 1290180024, 1, 'belenevansaa1658@yahoo.com'),
(889, 1290180024, 1, 'paul67harrison@yahoo.co.uk'),
(890, 1290180024, 1, 'patrickmilliers@yahoo.com'),
(891, 1290180024, 1, 'airbrushf@yahoo.com'),
(892, 1290180024, 1, 'mairealegi38@hotmail.com'),
(893, 1290180024, 1, 'stevenlusher80@hotmail.com'),
(894, 1290180024, 1, 'geoff4mullins@yahoo.co.uk'),
(895, 1290180024, 1, 'al54preston@yahoo.co.uk'),
(896, 1290180024, 1, 'edwinmcrae81@hotmail.com'),
(897, 1290180024, 1, 'shanesalisik@yahoo.com'),
(898, 1290180024, 1, 'hannahgames1@gmail.com'),
(899, 1290180024, 1, 'rensingcaroafa@hotmail.com'),
(900, 1290180024, 1, 'ieltstest@live.com'),
(901, 1290180024, 1, 'vincent59ellis@yahoo.co.uk'),
(902, 1290180024, 1, 'parkenmnchen@yahoo.com'),
(903, 1290180024, 1, 'newmarketingera@gmail.com'),
(904, 1290180024, 1, 'angela.ben39@yahoo.com'),
(905, 1290180024, 1, 'sabatercelger@hotmail.com'),
(906, 1290180024, 1, 'dasgood2@yahoo.co.uk'),
(907, 1290180024, 1, 'harrison53wyatt@yahoo.co.uk'),
(908, 1290180024, 1, 'abase12@gmail.com'),
(909, 1290180024, 1, 'larry12jacobs@yahoo.co.uk'),
(910, 1290180024, 1, 'johnpeter10020@yahoo.com'),
(911, 1290180024, 1, 'happyangee@yahoo.com'),
(912, 1290180024, 1, 'dummiemael@gmail.com'),
(913, 1290180024, 1, 'michaelzadel1@yahoo.com'),
(914, 1290180024, 1, 'van32bartlett@yahoo.co.uk'),
(915, 1290180024, 1, 'phillip17delacru@yahoo.co.uk'),
(916, 1290180024, 1, 'almasebring21@yahoo.co.uk'),
(917, 1290180024, 1, 'antithesismbt@sogou.com'),
(918, 1290180024, 1, 'annej5313@gmail.com'),
(919, 1290180024, 1, 'enrique58rice@yahoo.co.uk'),
(920, 1290180024, 1, 'kermitfarley41@yahoo.co.uk'),
(921, 1290180024, 1, 'nhlsportjersey@gmail.com'),
(922, 1290180024, 1, 'kocisynthirnce@hotmail.com'),
(923, 1290180024, 1, 'alva65solomon@yahoo.co.uk'),
(924, 1290180024, 1, 'anikaclaudiapitt@gmail.com'),
(925, 1290180024, 1, 'tamruskaxt@gmail.com'),
(926, 1290180024, 1, 'engineuser8@aol.com'),
(927, 1290180024, 1, 'thusterertr@hotmail.com'),
(928, 1290180024, 1, 'solgrundy7@gmail.com'),
(929, 1290180024, 1, 'nicholashrvey82@hotmail.com'),
(930, 1290180024, 1, 'weightliftel@yahoo.co.uk'),
(931, 1290180024, 1, 'jdawg28434@yahoo.co.uk'),
(932, 1290180024, 1, 'hugo99koch@yahoo.co.uk'),
(933, 1290180024, 1, 'gnadiahas@hotmail.com'),
(934, 1290180024, 1, 'bellissimafra@gmail.com'),
(935, 1290180024, 1, 'cambridge1@chiropracticpeak.com'),
(936, 1290180024, 1, 'cxush37777@yahoo.co.uk'),
(937, 1290180024, 1, 'jooblovekae6025@hotmail.com'),
(938, 1290180024, 1, 'knchilders@gmail.com'),
(939, 1290180024, 1, 'zojirushibread3@aol.com'),
(940, 1290180024, 1, 'charisma89white@hotmail.com'),
(941, 1290180024, 1, 'carl76brady@hotmail.com'),
(942, 1290180024, 1, 'heiderohlech@hotmail.com'),
(943, 1290180024, 1, 'esteban12mcneil@yahoo.co.uk'),
(944, 1290180024, 1, 'gerardo39burton@yahoo.co.uk'),
(945, 1290180024, 1, 'esteban12mcneil@yahoo.co.uk'),
(946, 1290180024, 1, 'eliseoabbott@yahoo.co.uk'),
(947, 1290180024, 1, 'timmy18cox@yahoo.co.uk'),
(948, 1290180024, 1, 'elisfeo13phillip@yahoo.co.uk'),
(949, 1290180024, 1, 'psitkozenti@hotmail.com'),
(950, 1290180024, 1, 'loyd11chase@yahoo.co.uk'),
(951, 1290180024, 1, 'willie4mack@yahoo.co.uk'),
(952, 1290180024, 1, 'juliahendricks22@gmail.com'),
(953, 1290180024, 1, 'jameswm1237@yahoo.co.uk'),
(954, 1290180024, 1, 'raileyshenkkat@hotmail.com'),
(955, 1290180024, 1, 'jimsdetox@yahoo.co.uk'),
(956, 1290180024, 1, 'vietnamvisanow@yahoo.co.uk'),
(957, 1290180024, 1, 'rachialsmith@gmail.com'),
(958, 1290180024, 1, 'hershel63good@yahoo.co.uk'),
(959, 1290180024, 1, 'hosting.online@yahoo.com'),
(960, 1290180024, 1, 'photovoltaikmodul@yahoo.com'),
(961, 1290180024, 1, 'juanamartignago08@hotmail.com'),
(962, 1290180024, 1, 'rainlun@gmail.com'),
(963, 1290180024, 1, 'cartoongames1@gmail.com'),
(964, 1290180024, 1, 'rahul.singh_singh@hotmail.com'),
(965, 1290180024, 1, 'distefanolwoje@hotmail.com'),
(966, 1290180024, 1, 'jleonardo1008@gmail.com'),
(967, 1290180024, 1, 'getprograde2010@gmail.com'),
(968, 1290180024, 1, 'dnmartin71@gmail.com'),
(969, 1290180024, 1, 'zofdugu@gmail.com'),
(970, 1290180024, 1, 'theinfo3products@yahoo.co.uk'),
(971, 1290180024, 1, 'cla1ryateees@yahoo.co.uk'),
(972, 1290180024, 1, 'admin@goldnecklacespendants.net'),
(973, 1290180024, 1, 'micah5shields@yahoo.co.uk'),
(974, 1290180024, 1, 'vilkamdl@gmail.com'),
(975, 1290180024, 1, 'perryreyes14@medicarepartcoverage.com'),
(976, 1290180024, 1, 'alfredo58briggs@yahoo.co.uk'),
(977, 1290180024, 1, 'vekelectric@yahoo.co.uk'),
(978, 1290180024, 1, 'seanhuff1@hotmail.com'),
(979, 1290180024, 1, 'cleveland17garci@yahoo.co.uk'),
(980, 1290180024, 1, 'lriberardide@hotmail.com'),
(981, 1290180024, 1, 'digrazialtuck@hotmail.com'),
(982, 1290180024, 1, 'raul67henson@yahoo.co.uk'),
(983, 1290180024, 1, 'on743playgame@yahoo.co.uk'),
(984, 1290180024, 1, 'kellyroan78@hotmail.com'),
(985, 1290180024, 1, 'marivicwales34@yahoo.com'),
(986, 1290180024, 1, 'aaron33glover@yahoo.co.uk'),
(987, 1290180024, 1, 'tommie14jensen@yahoo.co.uk'),
(988, 1290180024, 1, 'verocigarettes@yahoo.co.uk'),
(989, 1290180024, 1, 'rubyvlle@hotmail.com'),
(990, 1290180024, 1, 'hollis7castillo@yahoo.co.uk'),
(991, 1290180024, 1, 'agiampietrmeid@hotmail.com'),
(992, 1290180024, 1, 'cindykeller29@yahoo.com'),
(993, 1290180024, 1, 'nelidaliscbirt@hotmail.com'),
(994, 1290180024, 1, 'siwikliliaeidob@hotmail.com'),
(995, 1290180024, 1, 'wendysheng85@hotmail.com'),
(996, 1290180024, 1, 'neshrag70@gmail.com'),
(997, 1290180024, 1, 'dummervbafa@hotmail.com'),
(998, 1290180024, 1, 'otis46randolph@yahoo.co.uk'),
(999, 1290180024, 1, 'reed71hicks@yahoo.co.uk'),
(1000, 1290180024, 1, 'eryn88malena@hotmail.com'),
(1001, 1290180024, 1, 'magnoliagnembs@hotmail.com'),
(1002, 1290180024, 1, 'britcali@hotmail.com'),
(1003, 1290180024, 1, 'vava3330000@gmail.com'),
(1004, 1290180024, 1, 'joelakino@hotmail.com'),
(1005, 1290180024, 1, 'gmhappysong@gmail.com'),
(1006, 1290180024, 1, 'jayson1buchanan4@yahoo.co.uk'),
(1007, 1290180024, 1, 'tawnyhar24@yahoo.com'),
(1008, 1290180024, 1, 'jasper92kline@yahoo.co.uk'),
(1009, 1290180024, 1, 'neilstrauss@hotmail.co.uk'),
(1010, 1290180024, 1, 'josalker@gmail.com'),
(1011, 1290180024, 1, 'korvixru2@daytonchiropractorclinic.com'),
(1012, 1290180024, 1, 'npearlenerfam@hotmail.com'),
(1013, 1290180024, 1, 'conrad88weiss@yahoo.co.uk'),
(1014, 1290180024, 1, 'drogmoney@yahoo.com'),
(1015, 1290180024, 1, 'korvix7@chiropracticpeak.com'),
(1016, 1290180024, 1, 'bsilviataytt@hotmail.com'),
(1017, 1290180024, 1, 'gushannsen@gmail.com'),
(1018, 1290180024, 1, 'tracystokely78@yahoo.co.uk'),
(1019, 1290180024, 1, 'vergil1@chiropracticpeak.com'),
(1020, 1290180024, 1, 'korvixru1@daytonchiropractorclinic.com'),
(1021, 1290180024, 1, 'phillystrippers@yahoo.co.uk'),
(1022, 1290180024, 1, 'sgowensebsha@hotmail.com'),
(1023, 1290180024, 1, 'mariobestregistr@yahoo.co.uk'),
(1024, 1290180024, 1, 'jguidrozomc@hotmail.com'),
(1025, 1290180024, 1, 'opinglima@hotmail.com'),
(1026, 1290180024, 1, 'romanalipi@yahoo.com'),
(1027, 1290180024, 1, 'polykristallin@yahoo.com'),
(1028, 1290180024, 1, 'damac12345@gmail.com'),
(1029, 1290180024, 1, 'belenevansyy1656@yahoo.com'),
(1030, 1290180024, 1, 'anandrao7@gmail.com'),
(1031, 1290180024, 1, 'mbeckymicau@hotmail.com'),
(1032, 1290180024, 1, 'nannygrups@yahoo.com'),
(1033, 1290180024, 1, 'theresekgel@hotmail.com'),
(1034, 1290180024, 1, 'alicelarry108@yahoo.com'),
(1035, 1290180024, 1, 'johnsoncityjobs@yahoo.com'),
(1036, 1290180024, 1, 'phillip51schwart@yahoo.co.uk');
INSERT INTO `#__sl_SpamFilter` (`id`, `time`, `type`, `term`) VALUES
(1037, 1290180024, 1, 'delsiehayng@hotmail.com'),
(1038, 1290180024, 1, 'mthedaffe@hotmail.com'),
(1039, 1290180024, 1, 'harlan1flowers@yahoo.co.uk'),
(1040, 1290180024, 1, 'jdawg2834@yahoo.co.uk'),
(1041, 1290180024, 1, 'camposanoleli@hotmail.com'),
(1042, 1290180024, 1, 'derekevans82@hotmail.com'),
(1043, 1290180024, 1, 'xtreme7pips@gmail.com'),
(1044, 1290180024, 1, 'cedric.chloe@yahoo.com'),
(1045, 1290180024, 1, 'tweightmanehuch@hotmail.com'),
(1046, 1290180024, 1, 'robertwright87@hotmail.com'),
(1047, 1290180024, 1, 'marketinggold69i@hotmail.com'),
(1048, 1290180024, 1, 'ernesthoang@gmail.com'),
(1049, 1290180024, 1, 'elmer8hess@yahoo.co.uk'),
(1050, 1290180024, 1, 'elmer8hess@yahoo.co.uk'),
(1051, 1290180024, 1, 'sydney77frye@yahoo.co.uk'),
(1052, 1290180024, 1, 'antoine56delgado@yahoo.co.uk'),
(1053, 1290180024, 1, 'bospeaker01@yahoo.co.uk'),
(1054, 1290180024, 1, 'rigoberto375hurst@creditspot.org'),
(1055, 1290180024, 1, 'provillus@fatelines.com'),
(1056, 1290180024, 1, 'ecommercehost@yahoo.com'),
(1057, 1290180024, 1, 'tcryanassat@hotmail.com'),
(1058, 1290180024, 1, 'britishnidhi6@gmail.com'),
(1059, 1290180024, 1, 'rocco31mann@hotmail.com'),
(1060, 1290180024, 1, 'sharondaprboceh@hotmail.com'),
(1061, 1290180024, 1, 'fullcontactjunkie@yahoo.com'),
(1062, 1290180024, 1, 'santanuwebmaster@gmail.com'),
(1063, 1290180024, 1, 'energiesonnen@yahoo.com'),
(1064, 1290180024, 1, 'jalynmitchellmm16524@yahoo.com'),
(1065, 1290180024, 1, 'martinzblackz@yahoo.com'),
(1066, 1290180024, 1, 'duncan92workman@yahoo.co.uk'),
(1067, 1290180024, 1, 'rugged@brightsolutions.co.uk'),
(1068, 1290180024, 1, 'genovawilmkick@hotmail.com'),
(1069, 1290180024, 1, 'algarvelifestyle@gmail.com'),
(1070, 1290180024, 1, 'algarvelifestyle@gmail.com'),
(1071, 1290180024, 1, 'lyyzh78@163.com'),
(1072, 1290180024, 1, 'naiksatish36@gmail.com'),
(1073, 1290180024, 1, 'mikeybwelch@yahoo.co.uk'),
(1074, 1290180024, 1, 'v5+6@mymailindex.com'),
(1075, 1290180024, 1, 'normnabaro22@hotmail.com'),
(1076, 1290180024, 1, 'pwhitt1966@gmail.com'),
(1077, 1290180024, 1, 'guitars247sale@yahoo.co.uk'),
(1078, 1290180024, 1, 'alan2skinner@yahoo.co.uk'),
(1079, 1290180024, 1, 'richardhensley82@hotmail.com'),
(1080, 1290180024, 1, 'davidthorne78@yahoo.co.uk'),
(1081, 1290180024, 1, 'shirleywishart83@hotmail.com'),
(1082, 1290180024, 1, 'karenpaulk81@hotmail.com'),
(1083, 1290180024, 1, 'jooblovekae6023@hotmail.com'),
(1084, 1290180024, 1, 'cclaeysiet@hotmail.com'),
(1085, 1290180024, 1, 'ty84gillespie@yahoo.co.uk'),
(1086, 1290180024, 1, 'gertrudegaanee@hotmail.com'),
(1087, 1290180024, 1, 'bret73lambert@yahoo.co.uk'),
(1088, 1290180024, 1, 'iliccsses@hotmail.com'),
(1089, 1290180024, 1, 'ben10games1@gmail.com'),
(1090, 1290180024, 1, 'pretendcityorg@gmail.com'),
(1091, 1290180024, 1, 'clyde9hess@aol.com'),
(1092, 1290180024, 1, 'jooblovekae6022@hotmail.com'),
(1093, 1290180024, 1, 'davidhussy18@gmail.com'),
(1094, 1290180024, 1, 'rodrickrodrigunm@yahoo.co.uk'),
(1095, 1290180024, 1, 'tom9camacho@yahoo.co.uk'),
(1096, 1290180024, 1, 'terrencendodsonu@yahoo.co.uk'),
(1097, 1290180024, 1, 'boersenbrief4@yahoo.co.uk'),
(1098, 1290180024, 1, 'rosieszklarski46@hotmail.com'),
(1099, 1290180024, 1, 'petez58boyd@yahoo.co.uk'),
(1100, 1290180024, 1, 'antoniaebena@hotmail.com'),
(1101, 1290180024, 1, 'hahagarry@yashwantdedcollege.com'),
(1102, 1290180024, 1, 'seo2linkman@yahoo.co.uk'),
(1103, 1290180024, 1, 'roosevelt76blank@yahoo.co.uk'),
(1104, 1290180024, 1, 'jooblovekae6021@hotmail.com'),
(1105, 1290180024, 1, 'russel89warner@yahoo.co.uk'),
(1106, 1290180024, 1, 'reid91snyder@yahoo.co.uk'),
(1107, 1290180024, 1, 'lindathemom@gmail.com'),
(1108, 1290180024, 1, 'cal3629@yahoo.co.uk'),
(1109, 1290180024, 1, 'jooblovekae6020@hotmail.com'),
(1110, 1290180024, 1, 'larry65padilla@yahoo.co.uk'),
(1111, 1290180024, 1, 'mspradlinibi@hotmail.com'),
(1112, 1290180024, 1, 'listof50@yahoo.com'),
(1113, 1290180024, 1, 'johnlloyd32@ymail.com'),
(1114, 1290180024, 1, 'neelth88@yahoo.com'),
(1115, 1290180024, 1, 'robynjarressa@hotmail.com'),
(1116, 1290180024, 1, 'johnpitt89@yahoo.com'),
(1117, 1290180024, 1, 'karamjibril@yahoo.co.uk'),
(1118, 1290180024, 1, 'gayeewen34@gmail.com'),
(1119, 1290180024, 1, 'adlfhtlra@aol.com'),
(1120, 1290180024, 1, 'olliegwyneslcyed@hotmail.com'),
(1121, 1290180024, 1, 'karamjibril@yahoo.co.uk'),
(1122, 1290180024, 1, 'belenevansyy1654@yahoo.com'),
(1123, 1290180024, 1, 'curtinblair6@yahoo.co.uk'),
(1124, 1290180024, 1, 'margarito1mejia@yahoo.co.uk'),
(1125, 1290180024, 1, 'jamal37lopez@yahoo.co.uk'),
(1126, 1290180024, 1, 'deliceful@gmail.com'),
(1127, 1290180024, 1, 'tom19991@126.com'),
(1128, 1290180024, 1, 'anyloans@sogou.com'),
(1129, 1290180024, 1, 'gerry46whitney@yahoo.co.uk'),
(1130, 1290180024, 1, 'steve11korb@yahoo.co.uk'),
(1131, 1290180024, 1, 'marrydempeb@hotmail.com'),
(1132, 1290180024, 1, 'vjeniseghave@hotmail.com'),
(1133, 1290180024, 1, 'son17harvey@yahoo.co.uk'),
(1134, 1290180024, 1, 'shelton7mills@yahoo.co.uk'),
(1135, 1290180024, 1, 'will6pierce@hotmail.com'),
(1136, 1290180024, 1, 'barndesign11@yahoo.co.uk'),
(1137, 1290180024, 1, 'everett4short@yahoo.co.uk'),
(1138, 1290180024, 1, 'dianasmith1900@hotmail.com'),
(1139, 1290180024, 1, 'donnell4bray@yahoo.co.uk'),
(1140, 1290180024, 1, 'adrianjames82@hotmail.com'),
(1141, 1290180024, 1, 'clay7hanson@yahoo.co.uk'),
(1142, 1290180024, 1, 'asatovalengell@hotmail.com'),
(1143, 1290180024, 1, 'l88l@msn.com'),
(1144, 1290180024, 1, 'cruz15knowles@yahoo.co.uk'),
(1145, 1290180024, 1, 'trace828mcm@yahoo.co.uk'),
(1146, 1290180024, 1, 'esieverand@hotmail.com'),
(1147, 1290180024, 1, 'caleb9decker@yahoo.co.uk'),
(1148, 1290180024, 1, 'sammy2price@yahoo.co.uk'),
(1149, 1290180024, 1, 'carmelosearsthet@yahoo.co.uk'),
(1150, 1290180024, 1, 'backlinkvault@gmail.com'),
(1151, 1290180024, 1, 'luxuryhotelskotakinabalu@yahoo.com'),
(1152, 1290180024, 1, 'jooblovekae6019@hotmail.com'),
(1153, 1290180024, 1, 'micrositeemail@gmail.com'),
(1154, 1290180024, 1, 'michaelgoldstone2010@gmail.com'),
(1155, 1290180024, 1, 'valentin6kidd@yahoo.co.uk'),
(1156, 1290180024, 1, 'iei@brightsolutions.co.uk'),
(1157, 1290180024, 1, 'shanekakoperski98@hotmail.com'),
(1158, 1290180024, 1, 'josefinacurll75@hotmail.com'),
(1159, 1290180024, 1, 'altonfitz2419@aol.com'),
(1160, 1290180024, 1, 'jesushansen1111@yahoo.co.uk'),
(1161, 1290180024, 1, 'registry1520@yahoo.co.uk'),
(1162, 1290180024, 1, 'damien7ingram@aol.com'),
(1163, 1290180024, 1, 'winifredelizabetta@yahoo.co.uk'),
(1164, 1290180024, 1, 'polycrystalline@ymail.com'),
(1165, 1290180024, 1, 'colin45mckenzie@yahoo.co.uk'),
(1166, 1290180024, 1, 'sellingmachinechapter@gmail.com'),
(1167, 1290180024, 1, 'kirby36mejia@hotmail.com'),
(1168, 1290180024, 1, 'vinent5morro@aol.com'),
(1169, 1290180024, 1, 'xujingx@yahoo.com'),
(1170, 1290180024, 1, 'pedro45calhoun@yahoo.co.uk'),
(1171, 1290180024, 1, 'mjjones84@live.com'),
(1172, 1290180024, 1, 'burisarkar@gmail.com'),
(1173, 1290180024, 1, 'morris8hicks@yahoo.co.uk'),
(1174, 1290180024, 1, 'carhirenew123@live.co.uk'),
(1175, 1290180024, 1, 'clint1997davis@yahoo.co.uk'),
(1176, 1290180024, 1, 'breezyavailable@gmail.com'),
(1177, 1290180024, 1, 'rizwantahir1@gmail.com'),
(1178, 1290180024, 1, 'brwhitley78@yahoo.co.uk'),
(1179, 1290180024, 1, 'wallacekgibson@yahoo.co.uk'),
(1180, 1290180024, 1, 'lschwerinecki@hotmail.com'),
(1181, 1290180024, 1, 'flightcases@yahoo.cn'),
(1182, 1290180024, 1, 'dncastellone@gmail.com'),
(1183, 1290180024, 1, 'willis78harrison@yahoo.co.uk'),
(1184, 1290180024, 1, 'peterforsyth78@yahoo.co.uk'),
(1185, 1290180024, 1, 'espermax@live.com'),
(1186, 1290180024, 1, 'guadalupe84snyde@yahoo.co.uk'),
(1187, 1290180024, 1, 'rkaceybor@hotmail.com'),
(1188, 1290180024, 1, 'neopetseopoints1@yahoo.co.uk'),
(1189, 1290180024, 1, 'unlockiphone123@iphoneunlockzone.com'),
(1190, 1290180024, 1, 'daniel72morrison@yahoo.co.uk'),
(1191, 1290180024, 1, 'pratiksangle2@gmail.com'),
(1192, 1290180024, 1, 'bruno5pate@yahoo.co.uk'),
(1193, 1290180024, 1, 'abe6thomas@yahoo.co.uk'),
(1194, 1290180024, 1, 'samuel74morton@yahoo.co.uk'),
(1195, 1290180024, 1, 'alton36turner@freepregnancyguide.com'),
(1196, 1290180024, 1, 'ba6uwast@costmo.net'),
(1197, 1290180024, 1, 'kendall8porter@yahoo.co.uk'),
(1198, 1290180024, 1, 'gavin4clarke@yahoo.co.uk'),
(1199, 1290180024, 1, 'carrymill@ymail.com'),
(1200, 1290180024, 1, 'robbyanthony@minkaceilingfans.net'),
(1201, 1290180024, 1, 'janetkahza@hotmail.com'),
(1202, 1290180024, 1, '2010sportjersey@gmail.com'),
(1203, 1290180024, 1, 'gordondresses@yahoo.com'),
(1204, 1290180024, 1, 'jacksonsmith1989@hotmail.com'),
(1205, 1290180024, 1, 'zelleffizienz@yahoo.com'),
(1206, 1290180024, 1, 'martin@radicalbody.com'),
(1207, 1290180024, 1, 'brperry88@yahoo.co.uk'),
(1208, 1290180024, 1, 'gnemeno@yahoo.com'),
(1209, 1290180024, 1, 'kappenzellelich@hotmail.com'),
(1210, 1290180024, 1, 'williams5buckley@yahoo.co.uk'),
(1211, 1290180024, 1, 'indemandplumbing101@gmail.com'),
(1212, 1290180024, 1, 'designer86hodges@yahoo.co.uk'),
(1213, 1290180024, 1, 'tracy41aguilar@djsupplystore.com'),
(1214, 1290180024, 1, 'sandyland123@gmail.com'),
(1215, 1290180024, 1, 'gordonshelfenni@hotmail.com'),
(1216, 1290180024, 1, 'bbgadget111@aol.com'),
(1217, 1290180024, 1, 'pratiksangle1@gmail.com'),
(1218, 1290180024, 1, 'angelstone788@yahoo.com'),
(1219, 1290180024, 1, 'jamesstraw85@hotmail.com'),
(1220, 1290180024, 1, 'chairsforbaby628@yahoo.co.uk'),
(1221, 1290180024, 1, 'carter37frye@yahoo.co.uk'),
(1222, 1290180024, 1, 'antoine68harring@yahoo.co.uk'),
(1223, 1290180024, 1, 'belenevansee1653@yahoo.com'),
(1224, 1290180024, 1, 'carmelo37sears@gmail.com'),
(1225, 1290180024, 1, 'johnny@amztrk.com'),
(1226, 1290180024, 1, 'freddy77mcfarlan@yahoo.co.uk'),
(1227, 1290180024, 1, 'wallacekgibson@yahoo.co.uk'),
(1228, 1290180024, 1, 'johnromanshade90@yahoo.co.uk'),
(1229, 1290180024, 1, 'jacchaner@gmail.com'),
(1230, 1290180024, 1, 'lucas4vincent@yahoo.co.uk'),
(1231, 1290180024, 1, 'dallas86franklin@hotmail.com'),
(1232, 1290180024, 1, 'salvatore7parks@yahoo.co.uk'),
(1233, 1290180024, 1, 'dawngodwin80@hotmail.com'),
(1234, 1290180024, 1, 'robbie9walsh@hotmail.com'),
(1235, 1290180024, 1, 'bennie72rowe@yahoo.co.uk'),
(1236, 1290180024, 1, 'russel42gardner@debonnehumeur.com'),
(1237, 1290180024, 1, 'earllegette82@hotmail.com'),
(1238, 1290180024, 1, 'jeffrey6guzman@yahoo.co.uk'),
(1239, 1290180024, 1, 'wyatt58travis@djsupplystore.com'),
(1240, 1290180024, 1, 'johnie9gentry@hotmail.com'),
(1241, 1290180024, 1, 'gus44kline@yahoo.co.uk'),
(1242, 1290180024, 1, 'simonyardleyz@gmail.com'),
(1243, 1290180024, 1, 'jessicamc023@hotmail.com'),
(1244, 1290180024, 1, 'alexis21barron@hotmail.com'),
(1245, 1290180024, 1, 'everywherembt@sogou.com'),
(1246, 1290180024, 1, 'fumikodunkjb6@hotmail.com'),
(1247, 1290180024, 1, 'praprisri4466@yahoo.de'),
(1248, 1290180024, 1, 'felipe65howe@yahoo.co.uk'),
(1249, 1290180024, 1, 'randal3jensen@yahoo.co.uk'),
(1250, 1290180024, 1, 'evonnealasdair@yahoo.co.uk'),
(1251, 1290180024, 1, 'radfoza@gmail.com'),
(1252, 1290180024, 1, 'monte3hull@yahoo.co.uk'),
(1253, 1290180024, 1, 'dacrimecc@gmail.com'),
(1254, 1290180024, 1, 'zitkadutalschy@hotmail.com'),
(1255, 1290180024, 1, 'jeremy12boone@hotmail.com'),
(1256, 1290180024, 1, 'woodrow65waller@yahoo.co.uk'),
(1257, 1290180024, 1, 'maoflitter08@hotmail.com'),
(1258, 1290180024, 1, 'melvin29molina@aol.com'),
(1259, 1290180024, 1, 'jacob83mcleod@yahoo.co.uk'),
(1260, 1290180024, 1, 'belenevansbb1652@yahoo.com'),
(1261, 1290180024, 1, 'warrantsmcglade@yahoo.com'),
(1262, 1290180024, 1, 'nelsonfontana82@hotmail.com'),
(1263, 1290180024, 1, 'cruz87buck@debonnehumeur.com'),
(1264, 1290180024, 1, 'samudilwor23@yahoo.com'),
(1265, 1290180024, 1, 'fatburner79@yahoo.co.uk'),
(1266, 1290180024, 1, 'kerry17lyons@aol.com'),
(1267, 1290180024, 1, 'jackie26peterson@yahoo.co.uk'),
(1268, 1290180024, 1, 'dino48clarke@yahoo.co.uk'),
(1269, 1290180024, 1, 'barbelian13@hotmail.com'),
(1270, 1290180024, 1, 'booscuttingboards@gmail.com'),
(1271, 1290180024, 1, 'timsusan@mail.com'),
(1272, 1290180024, 1, 'simon6lewis@yahoo.co.uk'),
(1273, 1290180024, 1, 'xavierburns80@yahoo.co.uk'),
(1274, 1290180024, 1, 'denny1potts@yahoo.co.uk'),
(1275, 1290180024, 1, 'youtubeuser4@aol.com'),
(1276, 1290180024, 1, 'jruttenomb@hotmail.com'),
(1277, 1290180024, 1, 'eannarrica@hotmail.com'),
(1278, 1290180024, 1, 'basil77howe@yahoo.co.uk'),
(1279, 1290180024, 1, 'tomas8serrano@yahoo.co.uk'),
(1280, 1290180024, 1, 'dennis6burke@yahoo.co.uk'),
(1281, 1290180024, 1, 'lavern5hoover@aol.com'),
(1282, 1290180024, 1, 'lemelisabeanna@hotmail.com'),
(1283, 1290180024, 1, 'ababarathma@hotmail.com'),
(1284, 1290180024, 1, 'leon88whitehead@yahoo.co.uk'),
(1285, 1290180024, 1, 'dluposam@hotmail.com'),
(1286, 1290180024, 1, 'deinneustieout@yahoo.co.uk'),
(1287, 1290180024, 1, 'cheap54mattress7@yahoo.co.uk'),
(1288, 1290180024, 1, 'info1@coffeeinspector.com'),
(1289, 1290180024, 1, 'saltwater2aquari@yahoo.co.uk'),
(1290, 1290180024, 1, 'parkernikki95@yahoo.com'),
(1291, 1290180024, 1, 'andre81collier@yahoo.co.uk'),
(1292, 1290180024, 1, 'saxonlogins@gmail.com'),
(1293, 1290180024, 1, 'jameswilliam369@yahoo.com'),
(1294, 1290180024, 1, 'damikariffel@yahoo.com'),
(1295, 1290180024, 1, 'lonnirewe8lloyd3@yahoo.co.uk'),
(1296, 1290180024, 1, 'kennperk@hotmail.com'),
(1297, 1290180024, 1, 'kala-bittu-2@in.com'),
(1298, 1290180024, 1, 'hoangtusamac1029@yahoo.com'),
(1299, 1290180024, 1, 'binizie@hotmail.com'),
(1300, 1290180024, 1, 'gshavonibar@hotmail.com'),
(1301, 1290180024, 1, 'pablo12morris@buyingcontactlensesonline.com'),
(1302, 1290180024, 1, 'tyson76knight@yahoo.co.uk'),
(1303, 1290180024, 1, 'bremeoundad@hotmail.com'),
(1304, 1290180024, 1, 'katybarthdoor@hotmail.com'),
(1305, 1290180024, 1, 'irvin87morgan@yahoo.co.uk'),
(1306, 1290180024, 1, 'justinchan1@hotmail.co.uk'),
(1307, 1290180024, 1, 'antoniograppa82@hotmail.com'),
(1308, 1290180024, 1, 'garylowery81@hotmail.com'),
(1309, 1290180024, 1, 'libaishan200@gmail.com'),
(1310, 1290180024, 1, 'caiuscaity@gmail.com'),
(1311, 1290180024, 1, 'vamber78@yahoo.com'),
(1312, 1290180024, 1, 'vincent68morrow@yahoo.co.uk'),
(1313, 1290180024, 1, 'manieschafer29@hotmail.com'),
(1314, 1290180024, 1, 'carlynbeberwyk00@hotmail.com'),
(1315, 1290180024, 1, 'clark31hart@yahoo.co.uk'),
(1316, 1290180024, 1, 'marjorieroeda@hotmail.com'),
(1317, 1290180024, 1, 'rosannebttec@hotmail.com'),
(1318, 1290180024, 1, 'jpgreen@completehealthresource.info'),
(1319, 1290180024, 1, 'cocoveney17@gmail.com'),
(1320, 1290180024, 1, 'pwhitt1966@gmail.com'),
(1321, 1290180024, 1, 'marc8stevenson@yahoo.co.uk'),
(1322, 1290180024, 1, 'dwight9jenkins@yahoo.co.uk'),
(1323, 1290180024, 1, 'rogermason95@gmail.com'),
(1324, 1290180024, 1, 'healthcare79@gmail.com'),
(1325, 1290180024, 1, 'emory816odom@bloggingsite.info'),
(1326, 1290180024, 1, 'nhancock90210@yahoo.co.uk'),
(1327, 1290180024, 1, 'yunhizerarmi@hotmail.com'),
(1328, 1290180024, 1, 'heriberto87samps@yahoo.co.uk'),
(1329, 1290180024, 1, 'stvnson2010@gmail.com'),
(1330, 1290180024, 1, 'ahmad97wallace@hotmail.com'),
(1331, 1290180024, 1, 'sanjuanitagarasha83@hotmail.com'),
(1332, 1290180024, 1, 'boycows@yahoo.com'),
(1333, 1290180024, 1, 'barry41wiggins@yahoo.co.uk'),
(1334, 1290180024, 1, 'distancedegree94@yahoo.co.uk'),
(1335, 1290180024, 1, 'atiyahazzah@yahoo.co.uk'),
(1336, 1290180024, 1, 'davidwarner1937@hotmail.com'),
(1337, 1290180024, 1, 'edmund76stone@yahoo.co.uk'),
(1338, 1290180024, 1, 'mike27schultz@hotmail.com'),
(1339, 1290180024, 1, 'alvinawat@gmail.com'),
(1340, 1290180024, 1, 'oxleyputind@hotmail.com'),
(1341, 1290180024, 1, 'niffjoy@yahoo.com'),
(1342, 1290180024, 1, 'missyqwart@gmail.com'),
(1343, 1290180024, 1, 'irvin41silva@yahoo.co.uk'),
(1344, 1290180024, 1, 'antwan49mitchell@yahoo.co.uk'),
(1345, 1290180024, 1, 'lauraworthing5@yahoo.co.uk'),
(1346, 1290180024, 1, '9695@gmx.de'),
(1347, 1290180024, 1, 'ellaneckroad00@hotmail.com'),
(1348, 1290180024, 1, 'champak87@bhogawati-itc.com'),
(1349, 1290180024, 1, 'lemuel58crane@yahoo.co.uk'),
(1350, 1290180024, 1, 'posefauxongles@yahoo.com'),
(1351, 1290180024, 1, 'miliusjones@mail.com'),
(1352, 1290180024, 1, 'kimbrajulyeapllw@hotmail.com'),
(1353, 1290180024, 1, 'sinhto20101@zing.vn'),
(1354, 1290180024, 1, 'freddagjokaj22@hotmail.com'),
(1355, 1290180024, 1, 'vertiehenby08@hotmail.com'),
(1356, 1290180024, 1, 'courtneycurtis56@toni2.info'),
(1357, 1290180024, 1, 'chenlugang@gmail.com'),
(1358, 1290180024, 1, 'sencharp@hotmail.com'),
(1359, 1290180024, 1, 'jeffery52mullins@yahoo.co.uk'),
(1360, 1290180024, 1, 'cruz38hurley@yahoo.co.uk'),
(1361, 1290180024, 1, 'syberg01@gmail.com'),
(1362, 1290180024, 1, 'williams39ericks@yahoo.co.uk'),
(1363, 1290180024, 1, 'dagnywicih@hotmail.com'),
(1364, 1290180024, 1, 'verasteele205@yahoo.co.uk'),
(1365, 1290180024, 1, 'finnigan27stance@yahoo.co.uk'),
(1366, 1290180024, 1, 'kirk15cross@yahoo.co.uk'),
(1367, 1290180024, 1, 'husseinrimon@yahoo.co.uk'),
(1368, 1290180024, 1, 'ksresort01@yahoo.com'),
(1369, 1290180024, 1, 'yeildinvest87@yahoo.co.uk'),
(1370, 1290180024, 1, 'jjunkinsene@hotmail.com'),
(1371, 1290180024, 1, 'janukahasintha@yahoo.com'),
(1372, 1290180024, 1, 'colocatedhosting@yahoo.com'),
(1373, 1290180024, 1, 'donald7leaf@yahoo.com'),
(1374, 1290180024, 1, 'oliverle34@gmail.com'),
(1375, 1290180024, 1, 'stromsolar@yahoo.com'),
(1376, 1290180024, 1, 'kenrachalomer@hotmail.com'),
(1377, 1290180024, 1, 'rodrigo35fields@yahoo.co.uk'),
(1378, 1290180024, 1, 'alisaamaly@yahoo.com'),
(1379, 1290180024, 1, 'kareem7harris@yahoo.co.uk'),
(1380, 1290180024, 1, 'devinperezcc16576@yahoo.com'),
(1381, 1290180024, 1, 'timonabou23@hotmail.com'),
(1382, 1290180024, 1, 'l.chaos45@yahoo.com'),
(1383, 1290180024, 1, 'danabalceiro90@hotmail.com'),
(1384, 1290180024, 1, 'ignacio2meyer@hotmail.com'),
(1385, 1290180024, 1, 'savvyspice21@gmail.com'),
(1386, 1290180024, 1, 'andres55smith@yahoo.co.uk'),
(1387, 1290180024, 1, 'holmanlynn@gmail.com'),
(1388, 1290180024, 1, 'sunloyhimmon@yahoo.com'),
(1389, 1290180024, 1, 'forest4torenso@yahoo.co.uk'),
(1390, 1290180024, 1, 'milesvaughn99@yahoo.co.uk'),
(1391, 1290180024, 1, 'sue5marie@yahoo.co.uk'),
(1392, 1290180024, 1, 'ferren7menowae@hotmail.com'),
(1393, 1290180024, 1, 'jooblovekae6018@hotmail.com'),
(1394, 1290180024, 1, 'wordy@brightsolutions.co.uk'),
(1395, 1290180024, 1, 'suzzansmith01@gmail.com'),
(1396, 1290180024, 1, 'scottbaird83@hotmail.com'),
(1397, 1290180024, 1, 'bennie42reyes@yahoo.co.uk'),
(1398, 1290180024, 1, 'adrianandersen3@hotmail.com'),
(1399, 1290180024, 1, 'gocomputertraining@gmail.com'),
(1400, 1290180024, 1, 'tungtung@chiraganimatics.com'),
(1401, 1290180024, 1, 'beyonce@axisabroad.com'),
(1402, 1290180024, 1, 'najlepszamuzyka@gmail.com'),
(1403, 1290180024, 1, 'lucydousehaurg@hotmail.com'),
(1404, 1290180024, 1, 'grow4weed@yahoo.co.uk'),
(1405, 1290180024, 1, 'howard12@deltaskymilescreditcard.org'),
(1406, 1290180024, 1, 'albertfigla@hotmail.com'),
(1407, 1290180024, 1, 'rigoberto52guerr@stylesofmartialarts.com'),
(1408, 1290180024, 1, 'brettg344@yahoo.co.uk'),
(1409, 1290180024, 1, 'firmwork01@excite.com'),
(1410, 1290180024, 1, 'antonioplet@hotmail.com'),
(1411, 1290180024, 1, 'sshurjo@gmail.com'),
(1412, 1290180024, 1, 'emmett7shelton@loansspot.info'),
(1413, 1290180024, 1, 'deanohenson@hotmail.com'),
(1414, 1290180024, 1, 'beth52wright@yahoo.co.uk'),
(1415, 1290180024, 1, 'rloriazleis@hotmail.com'),
(1416, 1290180024, 1, 'lateshaporrnaid@hotmail.com'),
(1417, 1290180024, 1, 'monte64tate@yahoo.co.uk'),
(1418, 1290180024, 1, 'tobykitchin01@hotmail.com'),
(1419, 1290180024, 1, 'shawn3randolph@yahoo.co.uk'),
(1420, 1290180024, 1, 'kenneth1gibbsoo9@yahoo.co.uk'),
(1421, 1290180024, 1, 'demetrius9bray@stylesofmartialarts.com'),
(1422, 1290180024, 1, 'janetreno411@gmail.com'),
(1423, 1290180024, 1, 'michellegreer83@hotmail.com'),
(1424, 1290180024, 1, 'cherisemayatt@hotmail.com'),
(1425, 1290180024, 1, 'terrywahila@yahoo.co.uk'),
(1426, 1290180024, 1, 'ulysses84henry@yahoo.co.uk'),
(1427, 1290180024, 1, 'meharbanu@hotmail.com'),
(1428, 1290180024, 1, 'goldenmarashicom@yahoo.co.uk'),
(1429, 1290180024, 1, 'jamy52jamy@yahoo.co.uk'),
(1430, 1290180024, 1, 'wanitastrahin@hotmail.com'),
(1431, 1290180024, 1, 'abas@msn-stuff.se'),
(1432, 1290180024, 1, 'dougnadel23@yahoo.com'),
(1433, 1290180024, 1, 'miles9vaughn89@yahoo.co.uk'),
(1434, 1290180024, 1, 'jules29beasley@yahoo.co.uk'),
(1435, 1290180024, 1, 'oropesathesono@hotmail.com'),
(1436, 1290180024, 1, 'inocenciasorsit@hotmail.com'),
(1437, 1290180024, 1, 'devinperezii16580@yahoo.com'),
(1438, 1290180024, 1, 'dennissumbrano@gmail.com'),
(1439, 1290180024, 1, 'covermaker7@aol.com'),
(1440, 1290180024, 1, 'benjamin83massey@hotmail.com'),
(1441, 1290180024, 1, 'sankofa@wganda.com'),
(1442, 1290180024, 1, 'robertbocan28@hotmail.com'),
(1443, 1290180024, 1, 'seymour65doyle@yahoo.co.uk'),
(1444, 1290180024, 1, 'noundilboli@mamadac-rubiac-clipc.info'),
(1445, 1290180024, 1, 'talleyneil3@gmail.com'),
(1446, 1290180024, 1, 'nusliaise@uaclub.net'),
(1447, 1290180024, 1, 'adslover1@yahoo.co.uk'),
(1448, 1290180024, 1, 'henriburgo24@yahoo.com'),
(1449, 1290180024, 1, 'murphyb422@gmail.com'),
(1450, 1290180024, 1, 'ervin46delacruz@yahoo.co.uk'),
(1451, 1290180024, 1, 'delmar11holden@stvacation.com'),
(1452, 1290180024, 1, 'web20@proteinneed.com'),
(1453, 1290180024, 1, 'matt4gonzales@yahoo.co.uk'),
(1454, 1290180024, 1, 'hmelanywan@hotmail.com'),
(1455, 1290180024, 1, 'bluealexia53@yahoo.com'),
(1456, 1290180024, 1, 'josue45potter@yahoo.co.uk'),
(1457, 1290180024, 1, 'numbers54carpent@stvacation.com'),
(1458, 1290180024, 1, 'mikelgeorge54@yahoo.co.uk'),
(1459, 1290180024, 1, 'jljoeylyn67@gmail.com'),
(1460, 1290180024, 1, 'isisboughan24@hotmail.com'),
(1461, 1290180024, 1, 'elenalipschutz17@hotmail.com'),
(1462, 1290180024, 1, 'wf841618@yahoo.cn'),
(1463, 1290180024, 1, 'marhicks77@gmail.com'),
(1464, 1290180024, 1, 'naren.directory@yahoo.in'),
(1465, 1290180024, 1, 'otis.barnes@drywallwork.net'),
(1466, 1290180024, 1, 'mervin5bird@yahoo.co.uk'),
(1467, 1290180024, 1, 'rodrick91hess@yahoo.co.uk'),
(1468, 1290180024, 1, 'bellinilenous@hotmail.com'),
(1469, 1290180024, 1, 'rohdegaynelegg@hotmail.com'),
(1470, 1290180024, 1, 'daniellausana@yahoo.de'),
(1471, 1290180024, 1, 'jessicatolson64@yahoo.com'),
(1472, 1290180024, 1, 'lalysonielle@hotmail.com'),
(1473, 1290180024, 1, 'aswilson417@gmail.com'),
(1474, 1290180024, 1, 'michellecruz2332@yahoo.com'),
(1475, 1290180024, 1, 'bexebu4e@costmo.net'),
(1476, 1290180024, 1, 'leobanks@net257.com'),
(1477, 1290180024, 1, 'everett32velasqu@aol.com'),
(1478, 1290180024, 1, 'alva64kaufman@yahoo.co.uk'),
(1479, 1290180024, 1, 'cliff28perez@yahoo.co.uk'),
(1480, 1290180024, 1, '187187s@gmail.com'),
(1481, 1290180024, 1, 'scotty7wheeler@stvacation.com'),
(1482, 1290180024, 1, 'meccabingo243@yahoo.co.uk'),
(1483, 1290180024, 1, 'frank38smite@yahoo.co.uk'),
(1484, 1290180024, 1, 'edmund26stone@yahoo.co.uk'),
(1485, 1290180024, 1, 'donnell32peterso@hotmail.com'),
(1486, 1290180024, 1, 'proactivproactive@gmail.com'),
(1487, 1290180024, 1, 'gentraff121@gmail.com'),
(1488, 1290180024, 1, 'lindarichards3@gmail.com'),
(1489, 1290180024, 1, 'brentbatez@hotmail.com'),
(1490, 1290180024, 1, 'boyd7curtis@yahoo.co.uk'),
(1491, 1290180024, 1, 'bethelcackat@hotmail.com'),
(1492, 1290180024, 1, 'jason9wolf@hotmail.com'),
(1493, 1290180024, 1, 'brookemssala@hotmail.com'),
(1494, 1290180024, 1, 'wardsupplee88@yahoo.co.uk'),
(1495, 1290180024, 1, 'extreme@greenrevolutioninindia.com'),
(1496, 1290180024, 1, 'instantsocial77@gmail.com'),
(1497, 1290180024, 1, 'asakowskiwsko@hotmail.com'),
(1498, 1290180024, 1, 'milton4mcbride@yahoo.co.uk'),
(1499, 1290180024, 1, 'joemichaelstevens@gmail.com'),
(1500, 1290180024, 1, 'codyjurado@luvurgf.info'),
(1501, 1290180024, 1, 'spamerusinfo@yahoo.co.uk'),
(1502, 1290180024, 1, 'firathaber200@yahoo.com'),
(1503, 1290180024, 1, 'maa481miko@yahoo.co.uk'),
(1504, 1290180024, 1, 'ronniedolven46@hotmail.com'),
(1505, 1290180024, 1, 'monocrystalline16@gmail.com'),
(1506, 1290180024, 1, 'johnwilson343@gmail.com'),
(1507, 1290180024, 1, 'killfinsmiltesn@sify.com'),
(1508, 1290180024, 1, 'christiconlba@hotmail.com'),
(1509, 1290180024, 1, 'fonsterf@gmail.com'),
(1510, 1290180024, 1, 'ramiro3joyner@yahoo.co.uk'),
(1511, 1290180024, 1, 'ernestinedeuck@hotmail.com'),
(1512, 1290180024, 1, 'ernestinedeuck@hotmail.com'),
(1513, 1290180024, 1, 'adamsmith1150@gmail.com'),
(1514, 1290180024, 1, 'jimmy.adam52@yahoo.com'),
(1515, 1290180024, 1, 'wednesday0820@gmail.com'),
(1516, 1290180024, 1, 'margheritazaccagnino15@hotmail.com'),
(1517, 1290180024, 1, 'pwhitt1966@gmail.com'),
(1518, 1290180024, 1, 'evielaughbaum18@hotmail.com'),
(1519, 1290180024, 1, 'agamfaser@yahoo.com'),
(1520, 1290180024, 1, 'francistr23@yahoo.com'),
(1521, 1290180024, 1, 'phsunflower@163.com'),
(1522, 1290180024, 1, 'celenapidgeon16@hotmail.com'),
(1523, 1290180024, 1, 'celenapidgeon16@hotmail.com'),
(1524, 1290180024, 1, 'richamiller25@yahoo.com'),
(1525, 1290180024, 1, 'jonathan366ko@yahoo.co.uk'),
(1526, 1290180024, 1, 'vadolmanis77@gmail.com'),
(1527, 1290180024, 1, 'seginade@gmail.com'),
(1528, 1290180024, 1, 'fdesireerad@hotmail.com'),
(1529, 1290180024, 1, 'theokamir@hotmail.com'),
(1530, 1290180024, 1, 'jl016740@gmail.com'),
(1531, 1290180024, 1, 'stacey21roth@yahoo.co.uk'),
(1532, 1290180024, 1, 'photovoltiacmodule@gmail.com'),
(1533, 1290180024, 1, 'calvin45mckenzie@yahoo.co.uk'),
(1534, 1290180024, 1, 'chausgal@hotmail.com'),
(1535, 1290180024, 1, 'gaillovesallen@yahoo.co.uk'),
(1536, 1290180024, 1, 'hefteriuica@hotmail.com'),
(1537, 1290180024, 1, 'aaron92wood@yahoo.co.uk'),
(1538, 1290180024, 1, 'wilburn39phelps@socialnetworkingsites.org'),
(1539, 1290180024, 1, 'rlawanarmidf@hotmail.com'),
(1540, 1290180024, 1, 'japcyalandy@yahoo.com'),
(1541, 1290180024, 1, 'bruce1acevedo@aol.com'),
(1542, 1290180024, 1, 'mrvaska94@gmail.com'),
(1543, 1290180024, 1, 'nealfordhealth@googlemail.com'),
(1544, 1290180024, 1, 'fapturbo574s@hotmail.com'),
(1545, 1290180024, 1, 'trenton58mullen@yahoo.co.uk'),
(1546, 1290180024, 1, 'nubaquahfar@gmail.com'),
(1547, 1290180024, 1, 'noecristobalbrien@gmail.com'),
(1548, 1290180024, 1, 'liamarlethgrys@hotmail.com'),
(1549, 1290180024, 1, 'disneyguide17@gmail.com'),
(1550, 1290180024, 1, 'harlan4wright@yahoo.co.uk'),
(1551, 1290180024, 1, 'champak87@bhogawati-itc.com'),
(1552, 1290180024, 1, 'calvin736mosley@eseoinfo.info'),
(1553, 1290180024, 1, 'jack71berger@yahoo.co.uk'),
(1554, 1290180024, 1, 'jordan93leach@yahoo.co.uk'),
(1555, 1290180024, 1, 'luther2mckenzie@yahoo.co.uk'),
(1556, 1290180024, 1, '1234hair@gmail.com'),
(1557, 1290180024, 1, 'vrilacht@web.de'),
(1558, 1290180024, 1, 'dennisereionst@hotmail.com'),
(1559, 1290180024, 1, 'martinsmile01@yahoo.com'),
(1560, 1290180024, 1, 'silas35wilkins@socialnetworkingsites.org'),
(1561, 1290180024, 1, 'basilmorgan7@gmail.com'),
(1562, 1290180024, 1, 'chase73crosby@yahoo.co.uk'),
(1563, 1290180024, 1, 'classifiedinvest@yahoo.co.uk'),
(1564, 1290180024, 1, 'oscar63contreras@yahoo.co.uk'),
(1565, 1290180024, 1, 'wiley4burnett@yahoo.co.uk'),
(1566, 1290180024, 1, 'kasulee@hotmail.com'),
(1567, 1290180024, 1, 'pravin@sybasic.com'),
(1568, 1290180024, 1, '1234hair@gmail.com'),
(1569, 1290180024, 1, 'carter52carlson@yahoo.co.uk'),
(1570, 1290180024, 1, 'franklin68atkins@yahoo.co.uk'),
(1571, 1290180024, 1, 'watiswords@hotmail.de'),
(1572, 1290180024, 1, 'mckenziemaunsy@hotmail.com'),
(1573, 1290180024, 1, 'norman62english@yahoo.co.uk'),
(1574, 1290180024, 1, 'barton4adams@hotmail.com'),
(1575, 1290180024, 1, 'petershipers@yahoo.co.uk'),
(1576, 1290180024, 1, 'anatony1512@yahoo.com'),
(1577, 1290180024, 1, 'sclsdsk@gmail.com'),
(1578, 1290180024, 1, 'bonvertonet@gmail.com'),
(1579, 1290180024, 1, 'trackcellphone88@yahoo.co.uk'),
(1580, 1290180024, 1, 'dorian67hernande@hotmail.com'),
(1581, 1290180024, 1, 'aditya_ontheway@yahoo.com'),
(1582, 1290180024, 1, 'eldenhilston@gmail.com'),
(1583, 1290180024, 1, 'renatedoli@hotmail.com'),
(1584, 1290180024, 1, 'adamabas@yahoo.com'),
(1585, 1290180024, 1, 'marvinozarasa@gmail.com'),
(1586, 1290180024, 1, 'linarobina@yahoo.co.uk'),
(1587, 1290180024, 1, 'britishexpatnetwork@gmail.com'),
(1588, 1290180024, 1, 'wayne93trujillo@yahoo.co.uk'),
(1589, 1290180024, 1, 'francismirnessa@aol.com'),
(1590, 1290180024, 1, 'dorian67hernande@hotmail.com'),
(1591, 1290180024, 1, 'korgrand1@mygrandrapidschiropractic.com'),
(1592, 1290180024, 1, 'info1@bestpaidsurveyssecret.com'),
(1593, 1290180024, 1, 'dancelwet@yahoo.com'),
(1594, 1290180024, 1, 'daugroy@gmail.com'),
(1595, 1290180024, 1, 'adam62brown@hotmail.com'),
(1596, 1290180024, 1, 'sickjuly@gmail.com'),
(1597, 1290180024, 1, 'vadolmanis77@gmail.com'),
(1598, 1290180024, 1, 'onlineclassifieds12@gmail.com'),
(1599, 1290180024, 1, 'johnyboy2157@gmail.com'),
(1600, 1290180024, 1, 'llmackjack@yahoo.co.uk'),
(1601, 1290180024, 1, 'ofeliamcbride19@hotmail.com'),
(1602, 1290180024, 1, 'yongbagen@hotmail.com'),
(1603, 1290180024, 1, 'aurointeam@gmail.com'),
(1604, 1290180024, 1, 'keith5maynard@yahoo.co.uk'),
(1605, 1290180024, 1, '5@ckcstore.com'),
(1606, 1290180024, 1, 'sooveavioug@mail.ru'),
(1607, 1290180024, 1, 'sdorievakme@hotmail.com'),
(1608, 1290180024, 1, 'chance78velazque@gmail.com'),
(1609, 1290180024, 1, 'antwan3avery@socialnetworkingsites.org'),
(1610, 1290180024, 1, 'noel11le@yahoo.co.uk'),
(1611, 1290180024, 1, 'mimmo41catuso@hotmail.com'),
(1612, 1290180024, 1, 'jeromestricke@yahoo.com'),
(1613, 1290180024, 1, 'johnddaviess28@yahoo.co.uk'),
(1614, 1290180024, 1, 'timothybec22@yahoo.com'),
(1615, 1290180024, 1, 'richarrdo62belll@yahoo.co.uk'),
(1616, 1290180024, 1, 'smithwill1982621@yahoo.co.uk'),
(1617, 1290180024, 1, 'delmar84becker@yahoo.co.uk'),
(1618, 1290180024, 1, 'alycewassmumck@hotmail.com'),
(1619, 1290180024, 1, 'carmen92deleon@yahoo.co.uk'),
(1620, 1290180024, 1, 'dana38bennett@yahoo.co.uk'),
(1621, 1290180024, 1, 'daryl55dodson@yahoo.co.uk'),
(1622, 1290180024, 1, 'jasonmason75@yahoo.com'),
(1623, 1290180024, 1, 'marcus69graham@hotmail.com'),
(1624, 1290180024, 1, 'abah@sekuritionline.net'),
(1625, 1290180024, 1, 'smileysok2@gmail.com'),
(1626, 1290180024, 1, 'haydeeholmstead32@hotmail.com'),
(1627, 1290180024, 1, 'batugesa@gmail.com'),
(1628, 1290180024, 1, 'nusliaise@uaclub.net'),
(1629, 1290180024, 1, 'fishoilpharma@yahoo.com'),
(1630, 1290180024, 1, 'jackie8austin@yahoo.co.uk'),
(1631, 1290180024, 1, 'gnumbersarn@hotmail.com'),
(1632, 1290180024, 1, 'musclekertts@yahoo.co.uk'),
(1633, 1290180024, 1, 'michaleclark1234@hotmail.com'),
(1634, 1290180024, 1, 'leekawansky@gmail.com'),
(1635, 1290180024, 1, 'sandiegoseolove@gmail.com'),
(1636, 1290180024, 1, 'santiago4stanley@hotmail.com'),
(1637, 1290180024, 1, 'spencer98terry@yahoo.co.uk'),
(1638, 1290180024, 1, 'marketingagencyseattle@gmail.com'),
(1639, 1290180024, 1, 'jay72craft@yahoo.co.uk'),
(1640, 1290180024, 1, 'jackdanieltracy@gmail.com'),
(1641, 1290180024, 1, 'jbeilerire@hotmail.com'),
(1642, 1290180024, 1, 'linkbuilding298@gmail.com'),
(1643, 1290180024, 1, 'alphonse3clark@mail.com'),
(1644, 1290180024, 1, 'lsimonianeskea@hotmail.com'),
(1645, 1290180024, 1, 'omarmorin212@yahoo.co.uk'),
(1646, 1290180024, 1, 'ccsseo02@gmail.com'),
(1647, 1290180024, 1, 'conrad52weiss@hotmail.com'),
(1648, 1290180024, 1, 'franciesbarta@hotmail.com'),
(1649, 1290180024, 1, 'accounts@aloevera-produkter.net'),
(1650, 1290180024, 1, 'eliseo1ware@yahoo.co.uk'),
(1651, 1290180024, 1, 'josue64bright@yahoo.co.uk'),
(1652, 1290180024, 1, 'indeksikqwe@yahoo.co.uk'),
(1653, 1290180024, 1, 'ebonyerirsten@hotmail.com'),
(1654, 1290180024, 1, 'eduarda1282@gmail.com'),
(1655, 1290180024, 1, 'ggacontent@gmail.com'),
(1656, 1290180024, 1, 'lisatree123@gmail.com'),
(1657, 1290180024, 1, 'velharths@yahoo.com'),
(1658, 1290180024, 1, 'bernd7brodalkes@yahoo.co.uk'),
(1659, 1290180024, 1, 'ggacontent@gmail.com'),
(1660, 1290180024, 1, 'perpetualtraffic707@gmail.com'),
(1661, 1290180024, 1, 'godebtrelief@hotmail.com'),
(1662, 1290180024, 1, 'tomcrowell12@yahoo.co.uk'),
(1663, 1290180024, 1, 'denisemurtroc@hotmail.com'),
(1664, 1290180024, 1, 'nestor8boone@yahoo.co.uk'),
(1665, 1290180024, 1, 'evelynebomilla97@hotmail.com'),
(1666, 1290180024, 1, 'eleonorasloter32@hotmail.com'),
(1667, 1290180024, 1, 'grant7pell@yahoo.co.uk'),
(1668, 1290180024, 1, 'cruisedeals0@gmail.com'),
(1669, 1290180024, 1, 'sntgroger9@gmail.com'),
(1670, 1290180024, 1, 'gabrielcanas23@hotmail.com'),
(1671, 1290180024, 1, 'cyrus96torres@reviewsofcruiseships.com'),
(1672, 1290180024, 1, 'lakishamlghag@hotmail.com'),
(1673, 1290180024, 1, 'clyde47hess@yahoo.co.uk'),
(1674, 1290180024, 1, 'webtop28@yahoo.com'),
(1675, 1290180024, 1, 'kindlemacken@gmail.com'),
(1676, 1290180024, 1, 'mrehases@hotmail.com'),
(1677, 1290180024, 1, 'ochidalampos@yahoo.com'),
(1678, 1290180024, 1, 'platformrisers@yahoo.cn'),
(1679, 1290180024, 1, 'swdejesus88@yahoo.co.uk'),
(1680, 1290180024, 1, 'nickxxborn@gmail.com'),
(1681, 1290180024, 1, 'ruth_ulman@yahoo.com'),
(1682, 1290180024, 1, 'buffy36buffy@yahoo.co.uk'),
(1683, 1290180024, 1, 'jessie88shaw@yahoo.co.uk'),
(1684, 1290180024, 1, 'carobond24@gmail.com'),
(1685, 1290180024, 1, 'lothropaarush@hotmail.com'),
(1686, 1290180024, 1, 'reindhy22@gmail.com'),
(1687, 1290180024, 1, 'sunrentgroup@gmail.com'),
(1688, 1290180024, 1, 'jeremiah51ferrel@yahoo.co.uk'),
(1689, 1290180024, 1, 'pwhitt1966@gmail.com'),
(1690, 1290180024, 1, 'pravin@sybasic.com'),
(1691, 1290180024, 1, 'maryannjarvi79@hotmail.com'),
(1692, 1290180024, 1, 'groupbhandari@gmail.com'),
(1693, 1290180024, 1, 'jennykheif@gmail.com'),
(1694, 1290180024, 1, 'eugene73acosta@yahoo.co.uk'),
(1695, 1290180024, 1, 'frank5cotton@yahoo.co.uk'),
(1696, 1290180024, 1, 'utmenypeth@hotmail.com'),
(1697, 1290180024, 1, 'ervin15walters@yahoo.co.uk'),
(1698, 1290180024, 1, 'joe2942@yahoo.com'),
(1699, 1290180024, 1, 'aleasecox23@hotmail.com'),
(1700, 1290180024, 1, 'laanlace@yahoo.co.uk'),
(1701, 1290180024, 1, 'findoplysningent@hotmail.com'),
(1702, 1290180024, 1, 'ashleyong01@gmail.com'),
(1703, 1290180024, 1, 'nickolas74chang@yahoo.co.uk'),
(1704, 1290180024, 1, 'desert784@gmail.com'),
(1705, 1290180024, 1, 'sclsdsk@gmail.com'),
(1706, 1290180024, 1, 'smensefuncduh@gmx.com'),
(1707, 1290180024, 1, 'jimcarreyfanatic@gmail.com'),
(1708, 1290180024, 1, 'jimcarreyfanatic@gmail.com'),
(1709, 1290180024, 1, 'stasiaalde@hotmail.com'),
(1710, 1290180024, 1, 'dublyfury@yahoo.com'),
(1711, 1290180024, 1, 'he6ruru8@costmo.net'),
(1712, 1290180024, 1, 'moni_uap@hotmail.com'),
(1713, 1290180024, 1, 'eli5dorsey3@aol.com'),
(1714, 1290180024, 1, 'carey35lowe@yahoo.co.uk'),
(1715, 1290180024, 1, 'veselkalarrtiab@hotmail.com'),
(1716, 1290180024, 1, 'thimmonsilly@yahoo.com'),
(1717, 1290180024, 1, 'korgreenp1@mygreenbaychiropractic.com'),
(1718, 1290180024, 1, 'jt08@usbmemorysticks.net'),
(1719, 1290180024, 1, 'weston6craft@yahoo.co.uk'),
(1720, 1290180024, 1, 'greg9jefferson@yahoo.co.uk'),
(1721, 1290180024, 1, 'trueman@cafreeworld.com'),
(1722, 1290180024, 1, 'crbuy004@gmail.com'),
(1723, 1290180024, 1, 'shaffnercreff@hotmail.com'),
(1724, 1290180024, 1, 'frank5cotton@yahoo.co.uk'),
(1725, 1290180024, 1, 'pantastrad@yahoo.co.uk'),
(1726, 1290180024, 1, 'nbabiweekly45@yahoo.co.uk'),
(1727, 1290180024, 1, 'sclsdsk@gmail.com'),
(1728, 1290180024, 1, 'talleyneil3@gmail.com'),
(1729, 1290180024, 1, 'roosevelt6wagner@aol.com'),
(1730, 1290180024, 1, 'agustin5durham@yahoo.co.uk'),
(1731, 1290180024, 1, 'statueliberty322@yahoo.co.uk'),
(1732, 1290180024, 1, 'phicox54@yahoo.co.uk'),
(1733, 1290180024, 1, 'pedrnichol27@hotmail.com'),
(1734, 1290180024, 1, 'jiloz1501@zing.vn'),
(1735, 1290180024, 1, 'sheriseshaull92@hotmail.com'),
(1736, 1290180024, 1, 'garmin310xt81@yahoo.co.uk'),
(1737, 1290180024, 1, 'abdiqanibadr@yahoo.co.uk'),
(1738, 1290180024, 1, 'jacobwilliam10@yahoo.com'),
(1739, 1290180024, 1, 'margarito95bonne@yahoo.co.uk'),
(1740, 1290180024, 1, 'waterfiltersf@yahoo.com'),
(1741, 1290180024, 1, 'mjxhna30@gmail.com'),
(1742, 1290180024, 1, 'jacques9short@hotmail.com'),
(1743, 1290180024, 1, 'flexcin483@yahoo.co.uk'),
(1744, 1290180024, 1, 'poshasposh1@gmail.com'),
(1745, 1290180024, 1, 'pwhitt1966@gmail.com'),
(1746, 1290180024, 1, 'desmond86duncan@hotmail.com'),
(1747, 1290180024, 1, 'gmhappyneung@gmail.com'),
(1748, 1290180024, 1, 'akkumaranil85@gmail.com'),
(1749, 1290180024, 1, 'smoke@fatelines.com'),
(1750, 1290180024, 1, 'mjxhna28@gmail.com'),
(1751, 1290180024, 1, 'stacey3cash@yahoo.co.uk'),
(1752, 1290180024, 1, 'newjerseyguy29@yahoo.co.uk'),
(1753, 1290180024, 1, 'faustino@maximol.org'),
(1754, 1290180024, 1, 'david201060@ovi.com'),
(1755, 1290180024, 1, 'miles9goff@yahoo.co.uk'),
(1756, 1290180024, 1, 'jenagloster@gmail.com'),
(1757, 1290180024, 1, 'hahn343raymundo@hotmail.com'),
(1758, 1290180024, 1, 'cyril92townsend@yahoo.co.uk'),
(1759, 1290180024, 1, 'sixtimesixequalsthirtysix@gmail.com'),
(1760, 1290180024, 1, 'adamlong236@yahoo.com'),
(1761, 1290180024, 1, 'onlineprint12@gmail.com'),
(1762, 1290180024, 1, 'jim@finalroundmedia.com'),
(1763, 1290180024, 1, 'gracedey84@gmail.com'),
(1764, 1290180024, 1, 'hans@zwembril.com'),
(1765, 1290180024, 1, 'schandatloco@hotmail.com'),
(1766, 1290180024, 1, 'jonalexis09@gmail.com'),
(1767, 1290180024, 1, 'khseh4@gmail.com'),
(1768, 1290180024, 1, 'derrick88malone@yahoo.co.uk'),
(1769, 1290180024, 1, 'translationtrudy@gmail.com'),
(1770, 1290180024, 1, 'alaurenersoma@hotmail.com'),
(1771, 1290180024, 1, 'drummoj@yahoo.com'),
(1772, 1290180024, 1, 'bluecolorme@gmail.com'),
(1773, 1290180024, 1, 'donnie2dillard@private-jet-charter.net'),
(1774, 1290180024, 1, 'guoxiegwen56@hotmail.com'),
(1775, 1290180024, 1, 'frankifac@yahoo.com'),
(1776, 1290180024, 1, 'green_david@y7mail.com'),
(1777, 1290180024, 1, 'alfamalexb@gmail.com'),
(1778, 1290180024, 1, 'tesartamrassen@hotmail.com'),
(1779, 1290180024, 1, 'jmko1200@gmail.com'),
(1780, 1290180024, 1, 'larry74morton@yahoo.co.uk'),
(1781, 1290180024, 1, 'billga-webbhotell@msn-stuff.se'),
(1782, 1290180024, 1, 'kim25matthews@hotmail.com'),
(1783, 1290180024, 1, 'sandratran2010@hotmail.com'),
(1784, 1290180024, 1, 'genierthes@hotmail.com'),
(1785, 1290180024, 1, 'dewey661shepherd@yahoo.co.uk'),
(1786, 1290180024, 1, 'senuke999@yahoo.com'),
(1787, 1290180024, 1, 'peterpauliskego@hotmail.com'),
(1788, 1290180024, 1, 'mary.r.richardson@hotmail.com'),
(1789, 1290180024, 1, 'blakneyssale@hotmail.com'),
(1790, 1290180024, 1, '187187s@gmail.com'),
(1791, 1290180024, 1, 'bosedock4u@yahoo.co.uk'),
(1792, 1290180024, 1, 'clyde4clarke@yahoo.com'),
(1793, 1290180024, 1, 'korvixtorraninx@mytorrancechiropractor.com'),
(1794, 1290180024, 1, 'dominickbos@gmail.com'),
(1795, 1290180024, 1, 'dominic41gordon@yahoo.co.uk'),
(1796, 1290180024, 1, 'devinperezaa16583@yahoo.com'),
(1797, 1290180024, 1, 'diet@melileastore.com'),
(1798, 1290180024, 1, 'fleming_38@yahoo.com'),
(1799, 1290180024, 1, 'oyaness@gmail.com'),
(1800, 1290180024, 1, 'marion5nicholson@yahoo.co.uk'),
(1801, 1290180024, 1, 'jamal32mcgeezz@yahoo.co.uk'),
(1802, 1290180024, 1, 'attorneyjj@hotmail.com'),
(1803, 1290180024, 1, 'syneysolarpanel@gmail.com'),
(1804, 1290180024, 1, 'dilanban@yahoo.com'),
(1805, 1290180024, 1, 'zulu2trade@yahoo.co.uk'),
(1806, 1290180024, 1, 'bestasonu@hotmail.com'),
(1807, 1290180024, 1, 'ulla2mccullough@yahoo.co.uk'),
(1808, 1290180024, 1, 'videotoodvd12@gmail.com'),
(1809, 1290180024, 1, 'lanelletroena@hotmail.com'),
(1810, 1290180024, 1, 'johnnuthalls@yahoo.co.uk'),
(1811, 1290180024, 1, 'talleyneil3@gmail.com'),
(1812, 1290180024, 1, 'fariasriamen@hotmail.com'),
(1813, 1290180024, 1, 'franklin1hinton@yahoo.co.uk'),
(1814, 1290180024, 1, 'davvt4fff@aol.co.uk'),
(1815, 1290180024, 1, 'otis@myacaiberryreview.net'),
(1816, 1290180024, 1, 'wartrol@verytranslation.com'),
(1817, 1290180024, 1, '1234hair@gmail.com'),
(1818, 1290180024, 1, 'bellufino@letterkennystandard.info'),
(1819, 1290180024, 1, 'sunrentsolar@gmail.com'),
(1820, 1290180024, 1, 'itrendytrend@gmail.com'),
(1821, 1290180024, 1, 'rafael57guerra@yahoo.co.uk'),
(1822, 1290180024, 1, 'enrique45solis@yahoo.co.uk'),
(1823, 1290180024, 1, 'lane35cleveland@yahoo.co.uk'),
(1824, 1290180024, 1, 'beverson24@gmail.com'),
(1825, 1290180024, 1, 'frankiehrld@gmail.com'),
(1826, 1290180024, 1, 'darrelldallum@gmail.com'),
(1827, 1290180024, 1, 'pualgails22@gmail.com'),
(1828, 1290180024, 1, 'young57roy@yahoo.co.uk'),
(1829, 1290180024, 1, 'devinperezzz16584@yahoo.com'),
(1830, 1290180024, 1, 'eth3n23schu4tz@aol.com'),
(1831, 1290180024, 1, 'henrikkpedersen1@yahoo.co.uk'),
(1832, 1290180024, 1, 'blackrazi@hotmail.com'),
(1833, 1290180024, 1, 'kylemills456@hotmail.com'),
(1834, 1290180024, 1, 'decoratingbath@gmail.com'),
(1835, 1290180024, 1, 'yunuskito@hotmail.com'),
(1836, 1290180024, 1, 'maizahmalika@yahoo.co.uk'),
(1837, 1290180024, 1, 'georgestevano@gmail.com'),
(1838, 1290180024, 1, 'nichopeter23@yahoo.com'),
(1839, 1290180024, 1, 'dino88campbell@yahoo.co.uk'),
(1840, 1290180024, 1, 'sixtimesixequalsthirtysix@gmail.com'),
(1841, 1290180024, 1, 'tracy69blevins@yahoo.co.uk'),
(1842, 1290180024, 1, 'asalleylam@hotmail.com'),
(1843, 1290180024, 1, 'august85valdez@yahoo.co.uk'),
(1844, 1290180024, 1, 'linwood7ewing@aol.com'),
(1845, 1290180024, 1, 'clayton49puckett@yahoo.co.uk'),
(1846, 1290180024, 1, 'padroygedes@hotmail.com'),
(1847, 1290180024, 1, 'couvilliontry@hotmail.com'),
(1848, 1290180024, 1, 'onajoycelicc@hotmail.com'),
(1849, 1290180024, 1, 'roy7clayton@aol.com'),
(1850, 1290180024, 1, 'jefferson38rolli@yahoo.co.uk'),
(1851, 1290180024, 1, 'primusciby@hotmail.com'),
(1852, 1290180024, 1, 'freddy@nsaparadise.com'),
(1853, 1290180024, 1, 'earleenpiehl53@hotmail.com'),
(1854, 1290180024, 1, 'sheilaparker81@hotmail.com'),
(1855, 1290180024, 1, 'babyfurn1@gmx.com'),
(1856, 1290180024, 1, 'goofychick100@gmail.com'),
(1857, 1290180024, 1, 'nasdfgmadadada@rocketmail.com'),
(1858, 1290180024, 1, 'weldon78burris@private-jet-charter.net'),
(1859, 1290180024, 1, 'virtualhosting2010@gmail.com'),
(1860, 1290180024, 1, 'seopipz@gmail.com'),
(1861, 1290180024, 1, 'silviasawyer12@hotmail.com'),
(1862, 1290180024, 1, 'gemwales27@yahoo.com'),
(1863, 1290180024, 1, 'jeanettehera@hotmail.com'),
(1864, 1290180024, 1, 'jerome3johns@yahoo.co.uk'),
(1865, 1290180024, 1, 'seecarrot494@aol.com'),
(1866, 1290180024, 1, 'shop247baseball@yahoo.co.uk'),
(1867, 1290180024, 1, 'srhhayley@yahoo.com'),
(1868, 1290180024, 1, 'penneykate52@hotmail.com'),
(1869, 1290180024, 1, 'penneykate52@hotmail.com'),
(1870, 1290180024, 1, 'justin@seprofits.com'),
(1871, 1290180024, 1, 'winfred5green01@yahoo.co.uk'),
(1872, 1290180024, 1, 'wthaoste@hotmail.com'),
(1873, 1290180024, 1, 'jefferson38rolli@yahoo.co.uk'),
(1874, 1290180024, 1, 'tracy69blevins@yahoo.co.uk'),
(1875, 1290180024, 1, 'crbuy002@gmail.com'),
(1876, 1290180024, 1, '1234hair@gmail.com'),
(1877, 1290180024, 1, 'crbuy003@gmail.com'),
(1878, 1290180024, 1, 'davesteve1126@gmail.com'),
(1879, 1290180024, 1, 'puppyvarf@yahoo.com'),
(1880, 1290180024, 1, 'imsocialmark@gmail.com'),
(1881, 1290180024, 1, 'stacey2stanley@yahoo.co.uk'),
(1882, 1290180024, 1, 'toby67lott@yahoo.co.uk'),
(1883, 1290180024, 1, 'margaretdeclanjohnston@gmail.com'),
(1884, 1290180024, 1, 'champak87@bhogawati-itc.com'),
(1885, 1290180024, 1, 'bouwensstiro@hotmail.com'),
(1886, 1290180024, 1, 'maziescantu@hotmail.com'),
(1887, 1290180024, 1, 'investmentsproject1@googlemail.com'),
(1888, 1290180024, 1, 'woodrow87fox@aol.com'),
(1889, 1290180024, 1, 'orville2merritt@yahoo.co.uk'),
(1890, 1290180024, 1, 'fxchildsplays10@yahoo.co.uk'),
(1891, 1290180024, 1, 'sandralohan84@yahoo.co.uk'),
(1892, 1290180024, 1, 'cliffordlessmors@yahoo.com'),
(1893, 1290180024, 1, 'lourapolitano12@hotmail.com'),
(1894, 1290180024, 1, 'battery001@foxmail.com'),
(1895, 1290180024, 1, 'hostingcolocation@yahoo.com'),
(1896, 1290180024, 1, 'alden88collins@yahoo.co.uk'),
(1897, 1290180024, 1, 'seventimessevenequalsfortynine@gmail.com'),
(1898, 1290180024, 1, 'tuanamohn69@gmail.com'),
(1899, 1290180024, 1, 'spacifyseo007@gmail.com'),
(1900, 1290180024, 1, 'lieunh1105@gmail.com'),
(1901, 1290180024, 1, 'dingesmkez@hotmail.com'),
(1902, 1290180024, 1, 'cleanhousecomp@hotmail.com'),
(1903, 1290180024, 1, 'barcelonahotel@gmail.com'),
(1904, 1290180024, 1, 'menashe@newaysonline.tv'),
(1905, 1290180024, 1, 'plush0styler6@yahoo.co.uk'),
(1906, 1290180024, 1, 'gloriastoeber45@hotmail.com'),
(1907, 1290180024, 1, 'retlemercobre@mail.ru'),
(1908, 1290180024, 1, 'myplaceonweb@gmail.com'),
(1909, 1290180024, 1, 'talleyneil3@gmail.com'),
(1910, 1290180024, 1, 'nusliaise@uaclub.net'),
(1911, 1290180024, 1, 'lcpnyu8@tereg.ru'),
(1912, 1290180024, 1, 'danaedino41@hotmail.com'),
(1913, 1290180024, 1, 'sterlingemerson5@yahoo.co.uk'),
(1914, 1290180024, 1, 'ratul1122@gmail.com'),
(1915, 1290180024, 1, 'shokz2sc@shokzstarcraft2guidereview.com'),
(1916, 1290180024, 1, 'shevchenkondo@hotmail.com'),
(1917, 1290180024, 1, 'jimmie19knapp@yahoo.co.uk'),
(1918, 1290180024, 1, 'tyson37webster@yahoo.co.uk'),
(1919, 1290180024, 1, 'taniabcaj@hotmail.com'),
(1920, 1290180024, 1, 'dan78mobile@yahoo.co.uk'),
(1921, 1290180024, 1, 'antoine9stevens@yahoo.co.uk'),
(1922, 1290180024, 1, 'shirleysherrod200@yahoo.com'),
(1923, 1290180024, 1, 'frankmdouglas@gmail.com'),
(1924, 1290180024, 1, 'shritekseo@gmail.com'),
(1925, 1290180024, 1, 'gio6sipra@yahoo.co.uk'),
(1926, 1290180024, 1, 'lalarnavi@hotmail.com'),
(1927, 1290180024, 1, 'kurtisrose1@hotmail.com'),
(1928, 1290180024, 1, 'dannycoocoo@hotmail.com'),
(1929, 1290180024, 1, 'angya85sultes@yahoo.co.uk'),
(1930, 1290180024, 1, 'dhidrogoras@hotmail.com'),
(1931, 1290180024, 1, 'lucreciakagel56@hotmail.com'),
(1932, 1290180024, 1, 'marlon9barrett@yahoo.co.uk'),
(1933, 1290180024, 1, 'hubert97harrison@yahoo.co.uk'),
(1934, 1290180024, 1, 'krystatacket29@hotmail.com'),
(1935, 1290180024, 1, 'rachealcushman74@hotmail.com'),
(1936, 1290180024, 1, 'va3@goodorient.com'),
(1937, 1290180024, 1, 'reedkeyaai@yahoo.co.uk'),
(1938, 1290180024, 1, 'edconnur@yahoo.co.uk'),
(1939, 1290180024, 1, 'dereckbradford@gmail.com'),
(1940, 1290180024, 1, 'janice@exercisevideoshop.info'),
(1941, 1290180024, 1, 'coleman5waters@yahoo.co.uk'),
(1942, 1290180024, 1, 'orban66benzi@yahoo.co.uk'),
(1943, 1290180024, 1, 'bryon_burgess333@yahoo.co.uk'),
(1944, 1290180024, 1, 'raythomasn@gmail.com'),
(1945, 1290180024, 1, 'herman93humphrey@hotmail.com'),
(1946, 1290180024, 1, 'emmett91michael@yahoo.co.uk'),
(1947, 1290180024, 1, 'roy4zamora@plantingfruittree.com'),
(1948, 1290180024, 1, 'thesmokebot001@gmail.com'),
(1949, 1290180024, 1, 'jasminecasarz93@hotmail.com'),
(1950, 1290180024, 1, 'voviawear@gmail.com'),
(1951, 1290180024, 1, 'mieshamayhan87@hotmail.com'),
(1952, 1290180024, 1, 'lorihives51@hotmail.com'),
(1953, 1290180024, 1, 'augustine8pachec@yahoo.co.uk'),
(1954, 1290180024, 1, 'fenninill@yahoo.com'),
(1955, 1290180024, 1, 'dogboarding13@yahoo.com'),
(1956, 1290180024, 1, 'devpapa99@gmail.com'),
(1957, 1290180024, 1, 'beth02manning@yahoo.com'),
(1958, 1290180024, 1, 'theadvicespotcom@gmail.com'),
(1959, 1290180024, 1, 'mickey6gutierrez@yahoo.co.uk'),
(1960, 1290180024, 1, 'fangxiaomei2001@gmail.com'),
(1961, 1290180024, 1, 'manycriminals@sogou.com'),
(1962, 1290180024, 1, 'quianatrussellxcudw@hotmail.com'),
(1963, 1290180024, 1, 'paulenehinkle@gmail.com'),
(1964, 1290180024, 1, 'grover744sharp@creditspot.org'),
(1965, 1290180024, 1, 'wilburn89barron@yahoo.co.uk'),
(1966, 1290180024, 1, 'gerald4kemp@completeittraining.com'),
(1967, 1290180024, 1, 'earnest2palmer@aol.com'),
(1968, 1290180024, 1, 'luanasirio@hotmail.com'),
(1969, 1290180024, 1, 'tomas4serrano@aol.com'),
(1970, 1290180024, 1, 'garth8buckley@aol.com'),
(1971, 1290180024, 1, 'eli56chandler@yahoo.co.uk'),
(1972, 1290180024, 1, 'roosevelt4arnold@aol.com'),
(1973, 1290180024, 1, 'orville44carr@aol.com'),
(1974, 1290180024, 1, 'supemnzsoftix@mail.ru'),
(1975, 1290180024, 1, 'nubaquahfar@gmail.com'),
(1976, 1290180024, 1, 'scottie99ortiz@plantingfruittree.com'),
(1977, 1290180024, 1, 'mteishamist@hotmail.com'),
(1978, 1290180024, 1, 'hoorfromheaven@gmail.com'),
(1979, 1290180024, 1, 'fergusonkioysch@hotmail.com'),
(1980, 1290180024, 1, 'joecrosserisi@hotmail.com'),
(1981, 1290180024, 1, 'smateeniga@hotmail.com'),
(1982, 1290180024, 1, 'joecrosserisi@hotmail.com'),
(1983, 1290180024, 1, 'tonykeers@gmail.com'),
(1984, 1290180024, 1, 'bourneseo@yahoo.co.uk'),
(1985, 1290180024, 1, 'colettemshile@hotmail.com'),
(1986, 1290180024, 1, 'arnold@howtotravel.net'),
(1987, 1290180024, 1, 'donnell69cash@yahoo.co.uk'),
(1988, 1290180024, 1, 'pekane30@yahoo.co.uk'),
(1989, 1290180024, 1, 'rewardcindy@gmail.com'),
(1990, 1290180024, 1, 'dan12james@yahoo.co.uk'),
(1991, 1290180024, 1, 'duhale80@yahoo.co.uk'),
(1992, 1290180024, 1, 'julifedor@aol.com'),
(1993, 1290180024, 1, 'macano@macanohosting.com'),
(1994, 1290180024, 1, 'hivizteam@gmail.com'),
(1995, 1290180024, 1, 'dennistielmann@yahoo.com'),
(1996, 1290180024, 1, 'nolan7lee@yahoo.co.uk'),
(1997, 1290180024, 1, 'mveronarel@hotmail.com'),
(1998, 1290180024, 1, 'markbranigansa@yahoo.co.uk'),
(1999, 1290180024, 1, 'sydney75mccarty@hotmail.com'),
(2000, 1290180024, 1, 'wilfred1richards@yahoo.co.uk'),
(2001, 1290180024, 1, 'jailbreakiphone4@iphoneunlockzone.com'),
(2002, 1290180024, 1, 'sebastianleho539@gmail.com'),
(2003, 1290180024, 1, 'laurakrause63@yahoo.co.uk'),
(2004, 1290180024, 1, 'wilfred1richards@yahoo.co.uk'),
(2005, 1290180024, 1, 'completedtask@yahoo.com'),
(2006, 1290180024, 1, 'colettemshile@hotmail.com'),
(2007, 1290180024, 1, 'droidx@blogunexpected.com'),
(2008, 1290180024, 1, 'footballmagnets1@gmail.com'),
(2009, 1290180024, 1, 'nathaniel3hardin@yahoo.co.uk'),
(2010, 1290180024, 1, 'nelsonayo27@yahoo.com'),
(2011, 1290180024, 1, 'benoitbeaulne238@gmail.com'),
(2012, 1290180024, 1, 'hingtonklarsey20@yahoo.co.uk'),
(2013, 1290180024, 1, 'mrdatings@gmail.com'),
(2014, 1290180024, 1, 'antoine25salazar@plantingfruittree.com'),
(2015, 1290180024, 1, 'roderick38owens@yahoo.co.uk'),
(2016, 1290180024, 1, 'rultra2010@gmail.com'),
(2017, 1290180024, 1, 'george4sandoval@yahoo.co.uk'),
(2018, 1290180024, 1, 'melissa9040@gmail.com'),
(2019, 1290180024, 1, 'cyrusmanus@gmail.com'),
(2020, 1290180024, 1, 'angieluckmaddse@hotmail.com'),
(2021, 1290180024, 1, 'edward33battle@nutritionalsupplementsvitamins.com'),
(2022, 1290180024, 1, 'jdarceynez89@hotmail.com'),
(2023, 1290180024, 1, 'javier8morton@yahoo.co.uk'),
(2024, 1290180024, 1, 'spacifyseo007@gmail.com'),
(2025, 1290180024, 1, 'reedkeyaai@yahoo.co.uk'),
(2026, 1290180024, 1, 'sonny15hess@yahoo.co.uk'),
(2027, 1290180024, 1, 'reynaldo9buckner@yahoo.co.uk'),
(2028, 1290180024, 1, 'dunhamdhoes@hotmail.com'),
(2029, 1290180024, 1, 'bryce5tran@yahoo.co.uk'),
(2030, 1290180024, 1, 'marlynseidt50@hotmail.com'),
(2031, 1290180024, 1, 'ericabolland87@hotmail.com'),
(2032, 1290180024, 1, 'sheenaliveosle@hotmail.com'),
(2033, 1290180024, 1, 'lfrankeneyme@hotmail.com'),
(2034, 1290180024, 1, 'adamauton45@gmail.com'),
(2035, 1290180024, 1, 'nnikiksele@hotmail.com'),
(2036, 1290180024, 1, 'bestswimsuits@yahoo.co.uk'),
(2037, 1290180024, 1, 'kumshawgo21@hotmail.com'),
(2038, 1290180024, 1, 'infoproduct95kil@yahoo.co.uk'),
(2039, 1290180024, 1, 'jameshbutler83@hotmail.com'),
(2040, 1290180024, 1, 'jungrshicz@hotmail.com'),
(2041, 1290180024, 1, 'marilukedley04@hotmail.com'),
(2042, 1290180024, 1, 'atlwynn@gmail.com'),
(2043, 1290180024, 1, 'billybahbah79@yahoo.co.uk'),
(2044, 1290180024, 1, 'clarence93glass@yahoo.co.uk'),
(2045, 1290180024, 1, 'dusty1reilly9@aol.com'),
(2046, 1290180024, 1, 'maudeiagahl@hotmail.com'),
(2047, 1290180024, 1, 'randy48clarke@hotmail.com'),
(2048, 1290180024, 1, 'naturallygrowbreast@hotmail.com'),
(2049, 1290180024, 1, 'freecollegeinfo0@yahoo.co.uk'),
(2050, 1290180024, 1, 'allaussie63@hotmail.com'),
(2051, 1290180024, 1, 'humveewatson@gmail.com'),
(2052, 1290180024, 1, 'jacelynluddy50@hotmail.com');
INSERT INTO `#__sl_SpamFilter` (`id`, `time`, `type`, `term`) VALUES
(2053, 1290180024, 1, 'westlundrotog@hotmail.com'),
(2054, 1290180024, 1, 'likea219@hotmail.com'),
(2055, 1290180024, 1, 'gerry98waller@yahoo.co.uk'),
(2056, 1290180024, 1, 'juliachittam93@hotmail.com'),
(2057, 1290180024, 1, 'coy3pollard4@aol.com'),
(2058, 1290180024, 1, 'deannbredernitz61@hotmail.com'),
(2059, 1290180024, 1, 'robbincannuli23@hotmail.com'),
(2060, 1290180024, 1, 'dean86mueller@supersimplekeen.info'),
(2061, 1290180024, 1, 'harvey4luna@yahoo.co.uk'),
(2062, 1290180024, 1, 'laverne27macias@yahoo.co.uk'),
(2063, 1290180024, 1, 'shoshi78reynolds@yahoo.co.uk'),
(2064, 1290180024, 1, 'msbaffil@gmail.com'),
(2065, 1290180024, 1, 'devinperezmm16585@yahoo.com'),
(2066, 1290180024, 1, 'mangkuk365@yahoo.co.uk'),
(2067, 1290180024, 1, 'henlythrig@hotmail.com'),
(2068, 1290180024, 1, 'emery9byers@nutritionalsupplementsvitamins.com'),
(2069, 1290180024, 1, 'healthyandfitforever@gmail.com'),
(2070, 1290180024, 1, 'shawnceslie@rocketmail.com'),
(2071, 1290180024, 1, 'barimedill91@hotmail.com'),
(2072, 1290180024, 1, 'collettemarinko46@hotmail.com'),
(2073, 1290180024, 1, 'shebacaveney85@hotmail.com'),
(2074, 1290180024, 1, 'justinalunderman49@hotmail.com'),
(2075, 1290180024, 1, 'allen66vasquez@yahoo.co.uk'),
(2076, 1290180024, 1, 'cottoligiavecet@hotmail.com'),
(2077, 1290180024, 1, 'myles98roberts@hotmail.com'),
(2078, 1290180024, 1, 'michaeljames84@hotmail.com'),
(2079, 1290180024, 1, 'bkairte@hotmail.com'),
(2080, 1290180024, 1, 'ogawadebroirno@hotmail.com'),
(2081, 1290180024, 1, 'carlton1diaz@panaspace.com'),
(2082, 1290180024, 1, 'trsalt2010@hotmail.com'),
(2083, 1290180024, 1, 'jer18sot@yahoo.co.uk'),
(2084, 1290180024, 1, 'info@bestepilator.us'),
(2085, 1290180024, 1, 'omar72wallace@yahoo.co.uk'),
(2086, 1290180024, 1, 'vernon91duran@yahoo.co.uk'),
(2087, 1290180024, 1, 'slickmauritorwe@hotmail.com'),
(2088, 1290180024, 1, 'robbie93walsh@yahoo.co.uk'),
(2089, 1290180024, 1, 'orlandoiniguez@mail.com'),
(2090, 1290180024, 1, 'claynepaul@gmail.com'),
(2091, 1290180024, 1, 'jshgregory564@gmail.com'),
(2092, 1290180024, 1, 'stefan64weaver@aol.com'),
(2093, 1290180024, 1, 'devinperezdd16589@yahoo.com'),
(2094, 1290180024, 1, 'robbie93walsh@yahoo.co.uk'),
(2095, 1290180024, 1, 'oliviaperryslu960@forumprofilebacklinks.info'),
(2096, 1290180024, 1, 'kendall97ramsey@yahoo.co.uk'),
(2097, 1290180024, 1, 'janesteward69@yahoo.com'),
(2098, 1290180024, 1, 'sandiegoseoprog@gmail.com'),
(2099, 1290180024, 1, 'clitakeruer@hotmail.com'),
(2100, 1290180024, 1, 'alfredowens81@hotmail.com'),
(2101, 1290180024, 1, 'garrett15hawk12n@aol.com'),
(2102, 1290180024, 1, 'ignacialorin04@hotmail.com'),
(2103, 1290180024, 1, 'matthewwise2010@hotmail.com'),
(2104, 1290180024, 1, 'larry7owens@panaspace.com'),
(2105, 1290180024, 1, 'jefferson95harve@yahoo.co.uk'),
(2106, 1290180024, 1, 'demetrius82mccal@yahoo.co.uk'),
(2107, 1290180024, 1, 'laveirneiichair@yahoo.co.uk'),
(2108, 1290180024, 1, 'lotterymethod101@yahoo.co.uk'),
(2109, 1290180024, 1, 'gsheldonbuyer@yahoo.com'),
(2110, 1290180024, 1, 'aron85lewis@yahoo.co.uk'),
(2111, 1290180024, 1, 'sharacorloerr@hotmail.com'),
(2112, 1290180024, 1, 'lincoln5rodrique@panaspace.com'),
(2113, 1290180024, 1, 'reynaldo7booker@yahoo.co.uk'),
(2114, 1290180024, 1, 'admin@all-remediez.com'),
(2115, 1290180024, 1, 'gregmac037@gmail.com'),
(2116, 1290180024, 1, 'oregascharo@gmail.com'),
(2117, 1290180024, 1, 'paitoonjizard@gmail.com'),
(2118, 1290180024, 1, 'jasonkottke12@yahoo.co.uk'),
(2119, 1290180024, 1, 'jeffery15bush@hotmail.com'),
(2120, 1290180024, 1, 'stan21sanford@yahoo.co.uk'),
(2121, 1290180024, 1, 'jasolinatiger@gmail.com'),
(2122, 1290180024, 1, 'jamal39mcgee@yahoo.co.uk'),
(2123, 1290180024, 1, 'clint33fields22@aol.com'),
(2124, 1290180024, 1, 'tony69hood@yahoo.co.uk'),
(2125, 1290180024, 1, 'oniesibleyredi@hotmail.com'),
(2126, 1290180024, 1, 'turtonlashfaimi@hotmail.com'),
(2127, 1290180024, 1, 'cheapestairticke32@yahoo.co.uk'),
(2128, 1290180024, 1, 'lkoerberartho@hotmail.com'),
(2129, 1290180024, 1, 'floyd29lester@yahoo.co.uk'),
(2130, 1290180024, 1, 'rashmilillcaloj@hotmail.com'),
(2131, 1290180024, 1, 'geoffreysheppar1@yahoo.co.uk'),
(2132, 1290180024, 1, 'paulettewethok@hotmail.com'),
(2133, 1290180024, 1, 'gale6hurst@panaspace.com'),
(2134, 1290180024, 1, 'coy5pollard5@aol.com'),
(2135, 1290180024, 1, 'paullarn1@gmail.com'),
(2136, 1290180024, 1, 'robertdowries@gmail.com'),
(2137, 1290180024, 1, 'selectioncode@yahoo.com'),
(2138, 1290180024, 1, 'cameron86mcgowan@yahoo.co.uk'),
(2139, 1290180024, 1, 'tohateh2010@hotmail.com'),
(2140, 1290180024, 1, 'marisaniedermeyer25@hotmail.com'),
(2141, 1290180024, 1, 'freecollegeiginf@yahoo.co.uk'),
(2142, 1290180024, 1, 'rubifreydel01@hotmail.com'),
(2143, 1290180024, 1, 'ailenemortenson10@hotmail.com'),
(2144, 1290180024, 1, 'colby7sears@aol.com'),
(2145, 1290180024, 1, 'houseandlandibis@gmail.com'),
(2146, 1290180024, 1, 'emily322@live.com'),
(2147, 1290180024, 1, 'roxanakoepsel69@hotmail.com'),
(2148, 1290180024, 1, 'noellabottin29@hotmail.com'),
(2149, 1290180024, 1, 'celestemcrobbie16@hotmail.com'),
(2150, 1290180024, 1, 'moneyz778@hotmail.com'),
(2151, 1290180024, 1, 'edwardfgz@aol.com'),
(2152, 1290180024, 1, 'julehasiex@yahoo.co.uk'),
(2153, 1290180024, 1, 'jackb@real-vigrx-plus-reviews.com'),
(2154, 1290180024, 1, 'yoshiko67fptorreyj4gy@hotmail.com'),
(2155, 1290180024, 1, 'galkavolk@gmail.com'),
(2156, 1290180024, 1, 'myhammond20x@yahoo.com'),
(2157, 1290180024, 1, 'fista@eurourl.net'),
(2158, 1290180024, 1, 'mrcpermondini7@gmail.com'),
(2159, 1290180024, 1, 'simongrant49@gmail.com'),
(2160, 1290180024, 1, 'seodeepahosting@gmail.com'),
(2161, 1290180024, 1, 'khiylnhsab@qxmiyy.com'),
(2162, 1290180024, 1, 'cfoster@woodlandsdivorcelawyer.com'),
(2163, 1290180024, 1, 'thomataylor23@hotmail.com'),
(2164, 1290180024, 1, 'supercontrol101@yahoo.com'),
(2165, 1290180024, 1, 'puzzelesgames@gmail.com'),
(2166, 1290180024, 1, 'reneedavis@dcemail.com'),
(2167, 1290180024, 1, 'caitlinhnkrsnz@yahoo.com'),
(2168, 1290180024, 1, 'martinirvine25@hotmail.com'),
(2169, 1290180024, 1, 'marystephen85@gmail.com'),
(2170, 1290180024, 1, 'bagtoss@yashwantdedcollege.com'),
(2171, 1290180024, 1, 'eurodisneyparis@hotmail.fr'),
(2172, 1290180024, 1, 'annanowaliko22@gmail.com'),
(2173, 1290180024, 1, 'caseteluminoase@midoc.ro'),
(2174, 1290180024, 1, 'consumabilemedicale@midoc.ro'),
(2175, 1290180024, 1, 'cartidrept@midoc.ro'),
(2176, 1290180024, 1, 'cerceiargint@midoc.ro'),
(2177, 1290180024, 1, 'blogtext@cutii-lemn.ro'),
(2178, 1290180024, 1, 'gather@cutii-lemn.ro'),
(2179, 1290180024, 1, 'maziedeslandes675051@hotmail.com'),
(2180, 1290180024, 1, 'bestaffiliateprgrm@gmail.com'),
(2181, 1290180024, 1, 'denizkimdir0@aol.com'),
(2182, 1290180024, 1, 'homelessdarlingad@alternativeenergybenefits.com'),
(2183, 1290180024, 1, 'kyootwinterking@yahoo.co.uk'),
(2184, 1290180024, 1, 'infraredconcepts@gmail.com'),
(2185, 1290180024, 1, 'brianmorfs01@aol.com'),
(2186, 1290180024, 1, 'buildchestmuscles@gmail.com'),
(2187, 1290180024, 1, 'vogaaga@gmail.com'),
(2188, 1290180024, 1, 'myhammond20x@yahoo.com'),
(2189, 1290180024, 1, 'john09dowson@gmail.com'),
(2190, 1290180024, 1, 'hohamus@yandex.ru'),
(2191, 1290180024, 1, 'damuuro@gmail.com'),
(2192, 1290180024, 1, 'dulcerhyshe036330@gmail.com'),
(2193, 1290180024, 1, 'aminelbassiouni@yahoo.com'),
(2194, 1290180024, 1, 'ellisrobert134@yahoo.com'),
(2195, 1290180024, 1, 'toriehibhbrawleydqtf@hotmail.com'),
(2196, 1290180024, 1, 'boss.hacker89@yahoo.com.vn'),
(2197, 1290180024, 1, 'shane982williams@hotmail.com'),
(2198, 1290180024, 1, 'bigica@emigrantii.ro'),
(2199, 1290180024, 1, 'travoltajohn1000@yahoo.com'),
(2200, 1290180024, 1, 'articlesbase222@gmail.com'),
(2201, 1290180024, 1, 'vogaaga@gmail.com'),
(2202, 1290180024, 1, 'jazda1940@o2.pl'),
(2203, 1290180024, 1, 'mailmeme@o2.pl'),
(2204, 1290180024, 1, 'kiermilton@gmail.com'),
(2205, 1290180024, 1, 'iravelmeinova@gmail.com'),
(2206, 1290180024, 1, 'beehawley@mail.com'),
(2207, 1290180024, 1, 'mariusjansen18@yahoo.com'),
(2208, 1290180024, 1, 'brianmorfs01@aol.com'),
(2209, 1290180024, 1, 'holaparis@hotmail.fr'),
(2210, 1290180024, 1, 'zyndara_@hotmail.com'),
(2211, 1290180024, 1, 'alva7mckinpar@yahoo.co.uk'),
(2212, 1290180024, 1, 'deluxgoodnew@yahoo.com'),
(2213, 1290180024, 1, 'allstroika@gmail.com'),
(2214, 1290180024, 1, 'maria12thomas123@gmail.com'),
(2215, 1290180024, 1, 'lht192@gmail.com'),
(2216, 1290180024, 1, 'bas1492@tiscali.co.uk'),
(2217, 1290180024, 1, 'domainhost91@yahoo.com'),
(2218, 1290180024, 1, 'lephilip38@yahoo.com'),
(2219, 1290180024, 1, 'akilar123@googlemail.com'),
(2220, 1290180024, 1, 'gawainitahirahqy@gmail.com'),
(2221, 1290180024, 1, 'mervine49nielsen@yahoo.co.uk'),
(2222, 1290180024, 1, 'smithira21@yahoo.com'),
(2223, 1290180024, 1, 'sheidler.gilbert480@ymail.com'),
(2224, 1290180024, 1, 'forumpuss@yahoo.com'),
(2225, 1290180024, 1, 'nephiralough@gmail.com'),
(2226, 1290180024, 1, 'mwayne01@yahoo.com'),
(2227, 1290180024, 1, 'johnmakarenko@hotmail.com'),
(2228, 1290180024, 1, 'info@frontloadwasheranddryer.org'),
(2229, 1290180024, 1, 'luciefederrik@aol.com'),
(2230, 1290180024, 1, 'grant947@gmail.com'),
(2231, 1290180024, 1, 'carteregana@gmail.com'),
(2232, 1290180024, 1, 'bima9984@yahoo.com'),
(2233, 1290180024, 1, 'quijibohomer@gmail.com'),
(2234, 1290180024, 1, 'maraleonteva@gmail.com'),
(2235, 1290180024, 1, 'krishna_rajuu03@yahoo.com'),
(2236, 1290180024, 1, 'trafficsiphon8@yahoo.co.uk'),
(2237, 1290180024, 1, 'designlubna@gmail.com'),
(2238, 1290180024, 1, 'usman201008@yahoo.com'),
(2239, 1290180024, 1, 'supercontrol105@yahoo.com'),
(2240, 1290180024, 1, 'info@dreamdancerdesign.com'),
(2241, 1290180024, 1, 'bernettatojo825668@hotmail.com'),
(2242, 1290180024, 1, 'convertonet@gmail.com'),
(2243, 1290180024, 1, 'weightlossbox@gmail.com'),
(2244, 1290180024, 1, 'vanessa@firstlamedia.com'),
(2245, 1290180024, 1, 'reimer.geneviesm5@hotmail.com'),
(2246, 1290180024, 1, 'webmaster@obsidianvector.com'),
(2247, 1290180024, 1, 'speedupmycomputerfree@gmail.com'),
(2248, 1290180024, 1, 'kimcyrusilu@yahoo.com'),
(2249, 1290180024, 1, 'contact@likemyshare.com'),
(2250, 1290180024, 1, 'denisejohnson906@gmail.com'),
(2251, 1290180024, 1, 'mikesmith1566a@yahoo.com'),
(2252, 1290180024, 1, 'valasoll@gmail.com'),
(2253, 1290180024, 1, 'trastrap5@yahoo.com.cn'),
(2254, 1290180024, 1, 'abbie156@gmail.com'),
(2255, 1290180024, 1, 'duactuadiak@mail.ru'),
(2256, 1290180024, 1, 'goopxx11@yahoo.com'),
(2257, 1290180024, 1, 'abbie156@gmail.com'),
(2258, 1290180024, 1, 'gluazrdn@bolas-sob.co.cc'),
(2259, 1290180024, 1, 'ganjuman@yahoo.com'),
(2260, 1290180024, 1, 'devvickylegal@gmail.com'),
(2261, 1290180024, 1, '350779708@qq.com'),
(2262, 1290180024, 1, 'richardsuryajaya@gmail.com'),
(2263, 1290180024, 1, 'uniformmeet@sogou.com'),
(2264, 1290180024, 1, 'nastybellaya@gmail.com'),
(2265, 1290180024, 1, 'genrigetord@gmail.com'),
(2266, 1290180024, 1, 'nolan19bray@yahoo.co.uk'),
(2267, 1290180024, 1, 'teresogrone@gmail.com'),
(2268, 1290180024, 1, 'zabelin@involgu.ru'),
(2269, 1290180024, 1, 'bhuvanagokul1@gmail.com'),
(2270, 1290180024, 1, 'fashion2k10pro@yahoo.co.uk'),
(2271, 1290180024, 1, 'dgcasey.valliere2c@hotmail.com'),
(2272, 1290180024, 1, 'arnucha@googlemail.com'),
(2273, 1290180024, 1, 'smithed1982@gmail.com'),
(2274, 1290180024, 1, 'ballardrefugio609@gmail.com'),
(2275, 1290180024, 1, 'noinv86@gmail.com'),
(2276, 1290180024, 1, 'chadchau@ymail.com'),
(2277, 1290180024, 1, 'michaelzadel@gmail.com'),
(2278, 1290180024, 1, 'cellphoneguy7@loadransport.com'),
(2279, 1290180024, 1, 'sueisaiah455@gmail.com'),
(2280, 1290180024, 1, 'gallvorob@gmail.com'),
(2281, 1290180024, 1, 'ganjuman@yahoo.com'),
(2282, 1290180024, 1, 'dreamdays50@yahoo.com'),
(2283, 1290180024, 1, 'oldfroglet@aimbigatlife.com'),
(2284, 1290180024, 1, 'glacegrafixweb@yahoo.com'),
(2285, 1290180024, 1, 'bgraymergs4nylaii@hotmail.com'),
(2286, 1290180024, 1, 'marciebertolino@gmail.com'),
(2287, 1290180024, 1, 'kamagraforums@gmail.com'),
(2288, 1290180024, 1, 'alensolovushka@gmail.com'),
(2289, 1290180024, 1, 'tasana.colquittg@hotmail.com'),
(2290, 1290180024, 1, 'hallockfrcars@gmail.com'),
(2291, 1290180024, 1, 'rauchkvrelwandahgdw@hotmail.com'),
(2292, 1290180024, 1, 'johnbe3965@hotmail.com'),
(2293, 1290180024, 1, 'alensolovushka@gmail.com'),
(2294, 1290180024, 1, 'stimulatorcardiac@midoc.ro'),
(2295, 1290180024, 1, 'golftips2010@yahoo.cn'),
(2296, 1290180024, 1, 'malvaraluzer@gmail.com'),
(2297, 1290180024, 1, 'adrtechnology@gmail.com'),
(2298, 1290180024, 1, 'jordonlikins@hotmail.com'),
(2299, 1290180024, 1, 'coltchicken@aimbigatlife.com'),
(2300, 1290180024, 1, 'olloni.setserc@hotmail.com'),
(2301, 1290180024, 1, 'blondellabbenante951075@hotmail.com'),
(2302, 1290180024, 1, 'conceptionimlkemperp6zb@hotmail.com'),
(2303, 1290180024, 1, 'valkakotic@gmail.com'),
(2304, 1290180024, 1, 'blackhatboy1@gmail.com'),
(2305, 1290180024, 1, 'amioselvanto@gmail.com'),
(2306, 1290180024, 1, 'cresssgwqcorrinneuvy2@hotmail.com'),
(2307, 1290180024, 1, 'mrcpermondini7@gmail.com'),
(2308, 1290180024, 1, 'jamrising@yahoo.com'),
(2309, 1290180024, 1, 'lydiareyes35@gmail.com'),
(2310, 1290180024, 1, 'varaplod@gmail.com'),
(2311, 1290180024, 1, 'thompson44@live.com'),
(2312, 1290180024, 1, 'nycarson.evelindr@hotmail.com'),
(2313, 1290180024, 1, 'desmond38duncan@yahoo.co.uk'),
(2314, 1290180024, 1, 'vernongetzler@gmail.com'),
(2315, 1290180024, 1, 'israeler9roth@yahoo.co.uk'),
(2316, 1290180024, 1, 'bubuli.epoh@yahoo.com'),
(2317, 1290180024, 1, 'tristansoto216516@haltyourforeclosure.us'),
(2318, 1290180024, 1, 'fista@eurourl.net'),
(2319, 1290180024, 1, 'quijibomike@yahoo.co.uk'),
(2320, 1290180024, 1, 'jasonred0118@yahoo.com'),
(2321, 1290180024, 1, 'bananatobe1234@aol.com'),
(2322, 1290180024, 1, 'mariusjansen23@yahoo.com'),
(2323, 1290180024, 1, 'jasonred0118@yahoo.com'),
(2324, 1290180024, 1, 'mikeyardy@hotmail.com'),
(2325, 1290180024, 1, 'scsamuelconnolly@googlemail.com'),
(2326, 1290180024, 1, 'aldo22tate@saveyourmarriage.ws'),
(2327, 1290180024, 1, 'wordgames1@gmail.com'),
(2328, 1290180024, 1, 'forgegrrl@yahoo.co.uk'),
(2329, 1290180024, 1, 'cole94rios@hotmail.com'),
(2330, 1290180024, 1, '42dianepacheco@ibmevents.com'),
(2331, 1290180024, 1, 'jeanniesmith1402@dallasorthodontist.org'),
(2332, 1290180024, 1, 'kennithworkman1960@dallasorthodontist.org'),
(2333, 1290180024, 1, 'wade2campos@gmail.com'),
(2334, 1290180024, 1, 'steroids@mail333.com'),
(2335, 1290180024, 1, 'wade2campos@gmail.com'),
(2336, 1290180024, 1, 'szdortheadaodavissono@hotmail.com'),
(2337, 1290180024, 1, 'benito761jacobson@columbusbiz.info'),
(2338, 1290180024, 1, 'rudolfcraighead@hotmail.com'),
(2339, 1290180024, 1, 'maxwellpowersiii@yahoo.com'),
(2340, 1290180024, 1, 'wendynixonohio15@gmail.com'),
(2341, 1290180024, 1, 'brndette21@gmail.com'),
(2342, 1290180024, 1, 'gromovodchikov@gmail.com'),
(2343, 1290180024, 1, 'mariusjansen20@yahoo.com'),
(2344, 1290180024, 1, 'pierre.thomas89@yahoo.com'),
(2345, 1290180024, 1, 'eseissetiennam@yahoo.co.uk'),
(2346, 1290180024, 1, 'quaintchartreuse@yahoo.co.uk'),
(2347, 1290180024, 1, 'woodencrystalnk@dosomethinginteresting.com'),
(2348, 1290180024, 1, 'kymhendricksen403904@hotmail.com'),
(2349, 1290180024, 1, 'zxy027@hotmail.com'),
(2350, 1290180024, 1, 'melvin1clark31@yahoo.co.uk'),
(2351, 1290180024, 1, 'wilson86payne@hotmail.com'),
(2352, 1290180024, 1, 'acaiberryb88@google.com'),
(2353, 1290180024, 1, 'effectsofs95@google.com'),
(2354, 1290180024, 1, 'g.gfdgd@ymail.com'),
(2355, 1290180024, 1, 'rozwaemalika@gmail.com'),
(2356, 1290180024, 1, 'acompliaon60@google.com'),
(2357, 1290180024, 1, 'genericfio64@google.com'),
(2358, 1290180024, 1, 'mulhearnroxthi@gmail.com'),
(2359, 1290180024, 1, 'kristopher29trev@yahoo.co.uk'),
(2360, 1290180024, 1, 'john45skinner@mail.com'),
(2361, 1290180024, 1, 'sarah1_24174@yahoo.com'),
(2362, 1290180024, 1, 'descriptio58@google.com'),
(2363, 1290180024, 1, 'flouridece38@google.com'),
(2364, 1290180024, 1, 'divtiimi@gmail.com'),
(2365, 1290180024, 1, 'irkagolubichka@gmail.com'),
(2366, 1290180024, 1, 'orderviagr77@google.com'),
(2367, 1290180024, 1, 'atlantaacc62@google.com'),
(2368, 1290180024, 1, 'brennanser15@google.com'),
(2369, 1290180024, 1, 'viagrawith54@google.com'),
(2370, 1290180024, 1, 'judithv9kellogg@gmail.com'),
(2371, 1290180024, 1, 'admin@scanbook.net'),
(2372, 1290180024, 1, 'levitrarev49@google.com'),
(2373, 1290180024, 1, 'naturalvia90@google.com'),
(2374, 1290180024, 1, 'buyacaiber61@google.com'),
(2375, 1290180024, 1, 'acaiberrym98@google.com'),
(2376, 1290180024, 1, 'warmvents11@yahoo.com'),
(2377, 1290180024, 1, 'cheapfiori32@google.com'),
(2378, 1290180024, 1, 'buyingviag46@google.com'),
(2379, 1290180024, 1, 'xanaxdrugi34@google.com'),
(2380, 1290180024, 1, 'viagraonli18@google.com'),
(2381, 1290180024, 1, 'tramadolhy78@google.com'),
(2382, 1290180024, 1, 'nba2010jordan@hotmail.com'),
(2383, 1290180024, 1, 'gallacvetochek@gmail.com'),
(2384, 1290180024, 1, 'marcel96owens@yahoo.co.uk'),
(2385, 1290180024, 1, 'pshuai911@hotmail.com'),
(2386, 1290180024, 1, 'lowcostcia58@google.com'),
(2387, 1290180024, 1, 'xanaxwithd18@google.com'),
(2388, 1290180024, 1, 'celebrexst21@google.com'),
(2389, 1290180024, 1, 'ambienanda48@google.com'),
(2390, 1290180024, 1, 'klonopinvs20@google.com'),
(2391, 1290180024, 1, 'xanaxoverd28@google.com'),
(2392, 1290180024, 1, 'rodiolin@narod.ru'),
(2393, 1290180024, 1, 'farooq.9999@live.com'),
(2394, 1290180024, 1, 'berniecuiz@gmail.com'),
(2395, 1290180024, 1, 'marcus8ferguson@yahoo.com'),
(2396, 1290180024, 1, 'ultramer64@google.com'),
(2397, 1290180024, 1, 'zyrtecd26@google.com'),
(2398, 1290180024, 1, 'nexiumreac64@google.com'),
(2399, 1290180024, 1, 'zyrtecd20@google.com'),
(2400, 1290180024, 1, 'body2build@hotmail.co.uk'),
(2401, 1290180024, 1, 'adderallab15@google.com'),
(2402, 1290180024, 1, 'prescripti79@google.com'),
(2403, 1290180024, 1, 'verycheapt72@google.com'),
(2404, 1290180024, 1, 'ordercaris51@google.com'),
(2405, 1290180024, 1, 'subactions97@google.com'),
(2406, 1290180024, 1, 'valtrexvsa89@google.com'),
(2407, 1290180024, 1, 'doxycyclin81@google.com'),
(2408, 1290180024, 1, 'singulairs46@google.com'),
(2409, 1290180024, 1, 'buyhydroco32@google.com'),
(2410, 1290180024, 1, 'freedietpi47@google.com'),
(2411, 1290180024, 1, 'buyhydroco71@google.com'),
(2412, 1290180024, 1, 'canclomidc86@google.com'),
(2413, 1290180024, 1, 'vicodinreh40@google.com'),
(2414, 1290180024, 1, 'mahjonggames12@gmail.com'),
(2415, 1290180024, 1, 'cozaarside64@google.com'),
(2416, 1290180024, 1, 'mikealvares56@yahoo.com'),
(2417, 1290180024, 1, 'luciano27aderickso@yahoo.co.uk'),
(2418, 1290180024, 1, 'tomphilip6@gmail.com'),
(2419, 1290180024, 1, 'doctorswho27@google.com'),
(2420, 1290180024, 1, 'susanrwarren01@hotmail.com'),
(2421, 1290180024, 1, 'haroldkenney@hotmail.com'),
(2422, 1290180024, 1, 'dasika2010@mail.ru'),
(2423, 1290180024, 1, 'busparford96@google.com'),
(2424, 1290180024, 1, 'jhonnydon2010@gmail.com'),
(2425, 1290180024, 1, 'dangerouss75@google.com'),
(2426, 1290180024, 1, 'effexorgen28@google.com'),
(2427, 1290180024, 1, 'buyalprazo10@google.com'),
(2428, 1290180024, 1, 'williams45pennin@hotmail.com'),
(2429, 1290180024, 1, 'valiumonli13@google.com'),
(2430, 1290180024, 1, 'kdbaga@gmail.com'),
(2431, 1290180024, 1, 'cialistada57@google.com'),
(2432, 1290180024, 1, 'premarinin79@google.com'),
(2433, 1290180024, 1, 'phentermin33@google.com'),
(2434, 1290180024, 1, 'ziyizang786@gmail.com'),
(2435, 1290180024, 1, 'mack9turner@yahoo.co.uk'),
(2436, 1290180024, 1, 'hsag0523@gmail.com'),
(2437, 1290180024, 1, 'effexorxrv48@google.com'),
(2438, 1290180024, 1, 'prozacside43@google.com'),
(2439, 1290180024, 1, 'adipexdang56@google.com'),
(2440, 1290180024, 1, 'purchasevi78@google.com'),
(2441, 1290180024, 1, 'somas33@google.com'),
(2442, 1290180024, 1, 'cialisonli34@google.com'),
(2443, 1290180024, 1, 'colerosariolokq@yahoo.co.uk'),
(2444, 1290180024, 1, 'charliker2@mail.ru'),
(2445, 1290180024, 1, 'tangledfanatic@yahoo.com'),
(2446, 1290180024, 1, 'joshua75briggs@aol.com'),
(2447, 1290180024, 1, 'jps1982@live.com'),
(2448, 1290180024, 1, '+elizabethfuumcdanielcpde@hotmail.com'),
(2449, 1290180024, 1, 'caprice23cap@yahoo.co.uk'),
(2450, 1290180024, 1, 'brent7blackwell@hotmail.com'),
(2451, 1290180024, 1, 'haltonjames@gmail.com'),
(2452, 1290180024, 1, 'metalbunk55b@yahoo.co.uk'),
(2453, 1290180024, 1, 'bolingerjohn@gmail.com'),
(2454, 1290180024, 1, 'wohld_min578@yahoo.com'),
(2455, 1290180024, 1, 'phones4you911@yahoo.co.uk'),
(2456, 1290180024, 1, 'mpb4today11@yahoo.com'),
(2457, 1290180024, 1, 'laney.janelle3051950@yahoo.com'),
(2458, 1290180024, 1, 'darwin34potter@yahoo.co.uk'),
(2459, 1290180024, 1, 'voloant@gmail.com'),
(2460, 1290180024, 1, 'dinnashulc@gmail.com'),
(2461, 1290180024, 1, 'romeo78silva@hotmail.com'),
(2462, 1290180024, 1, 'burt38whitley@yahoo.co.uk'),
(2463, 1290180024, 1, 'tattastallin@gmail.com'),
(2464, 1290180024, 1, 'andomark87@gmail.com'),
(2465, 1290180024, 1, 'kelseylorianne@yahoo.com'),
(2466, 1290180024, 1, 'alvin6fowler@yahoo.co.uk'),
(2467, 1290180024, 1, 'kkarenschock@yahoo.com'),
(2468, 1290180024, 1, 'phillisrocawr388@yahoo.com'),
(2469, 1290180024, 1, 'tetryhorne@yahoo.com'),
(2470, 1290180024, 1, 'tatrayakov@gmail.com'),
(2471, 1290180024, 1, 'leadmachinehq@gmail.com'),
(2472, 1290180024, 1, 'ofdepriestszpdaniellep@hotmail.com'),
(2473, 1290180024, 1, 'sarinabrickles732323@hotmail.com'),
(2474, 1290180024, 1, 'touficsarkis@hotmail.com'),
(2475, 1290180024, 1, 'anne28@hotmail.ph'),
(2476, 1290180024, 1, 'heightscj@yahoo.com'),
(2477, 1290180024, 1, 'bobbywaynejansma@gmail.com'),
(2478, 1290180024, 1, 'baby201008@yahoo.com'),
(2479, 1290180024, 1, 'danorlando95@yahoo.com'),
(2480, 1290180024, 1, 'jimmyjonesfrom@aol.com'),
(2481, 1290180024, 1, 'gang_well_pong@hotmail.com'),
(2482, 1290180024, 1, 'tangled.iwatch@yahoo.com'),
(2483, 1290180024, 1, '2010nhljersey@gmail.com'),
(2484, 1290180024, 1, 'garymullins3714@gmail.com'),
(2485, 1290180024, 1, 'jte667@gmail.com'),
(2486, 1290180024, 1, 'harleymeighan@yahoo.com'),
(2487, 1290180024, 1, 'fancases@yahoo.com'),
(2488, 1290180024, 1, 'sandiegodoctor0@aol.com'),
(2489, 1290180024, 1, 'eliza15rose@gmail.com'),
(2490, 1290180024, 1, 'billynaismith@yahoo.co.uk'),
(2491, 1290180024, 1, 'waitmet1414@gmail.com'),
(2492, 1290180024, 1, 'archie57hunter@aol.com'),
(2493, 1290180024, 1, 'hans13santos@yahoo.co.uk'),
(2494, 1290180024, 1, 'stereotypical123@gmail.com'),
(2495, 1290180024, 1, 'sevastjanll@janek.ru'),
(2496, 1290180024, 1, 'margoshaivann@gmail.com'),
(2497, 1290180024, 1, 'justingrave24@hotmail.com'),
(2498, 1290180024, 1, 'christophrw28@gmail.com'),
(2499, 1290180024, 1, 'marcuspfox@hotmail.com'),
(2500, 1290180024, 1, 'roderick4suarez@yahoo.co.uk'),
(2501, 1290180024, 1, 'crocopcop@aol.com'),
(2502, 1290180024, 1, 'marragolubkka@gmail.com'),
(2503, 1290180024, 1, 'ergoproxitical@yahoo.com'),
(2504, 1290180024, 1, 'clerinsmadona@sify.com'),
(2505, 1290180024, 1, 'thevisualart@gmail.com'),
(2506, 1290180024, 1, 'peter8moreno@yahoo.co.uk'),
(2507, 1290180024, 1, 'leshiewsidevex@hotmail.com'),
(2508, 1290180024, 1, 'rocketweb86@gmail.com'),
(2509, 1290180024, 1, 'domainhost91@yahoo.com'),
(2510, 1290180024, 1, 'disguyjohnson@yahoo.com'),
(2511, 1290180024, 1, 'moshikjq@gmail.com'),
(2512, 1290180024, 1, 'lennbezruk@gmail.com'),
(2513, 1290180024, 1, 'gloria_cooper_80@yahoo.com'),
(2514, 1290180024, 1, 'linnamirovaya@gmail.com'),
(2515, 1290180024, 1, 'prohorevnakrutkin@gmail.com'),
(2516, 1290180024, 1, 'gloriaivanoff@aol.com'),
(2517, 1290180024, 1, 'homeandbeds@yahoo.com'),
(2518, 1290180024, 1, 'carguy@buyherepayheredealer.net'),
(2519, 1290180024, 1, 'kent23hagorerson@yahoo.co.uk'),
(2520, 1290180024, 1, 'verundese@mail.ru'),
(2521, 1290180024, 1, 'larramatvey@gmail.com'),
(2522, 1290180024, 1, 'danial66fuller@hotmail.com'),
(2523, 1290180024, 1, 'aaaa33030@yahoo.com'),
(2524, 1290180024, 1, 'aliceturihman@gmail.com'),
(2525, 1290180024, 1, 'sterling6412hutc@yahoo.co.uk'),
(2526, 1290180024, 1, 'wendiexhv@aol.com'),
(2527, 1290180024, 1, 'dodiemabenbkaoe@hotmail.com'),
(2528, 1290180024, 1, 'huyvandung@mail15.com'),
(2529, 1290180024, 1, 'premoses@mail15.com'),
(2530, 1290180024, 1, 'vinensia@gmail.com'),
(2531, 1290180024, 1, 'stokesbarbara594@hotmail.com'),
(2532, 1290180024, 1, 'holaparis@hotmail.fr'),
(2533, 1290180024, 1, 'zyndara_@hotmail.com'),
(2534, 1290180024, 1, 'alva7mckinpar@yahoo.co.uk'),
(2535, 1290180024, 1, 'deluxgoodnew@yahoo.com'),
(2536, 1290180024, 1, 'allstroika@gmail.com'),
(2537, 1290180024, 1, 'maria12thomas123@gmail.com'),
(2538, 1290180024, 1, 'lht192@gmail.com'),
(2539, 1290180024, 1, 'bas1492@tiscali.co.uk'),
(2540, 1290180024, 1, 'domainhost91@yahoo.com'),
(2541, 1290180024, 1, 'lephilip38@yahoo.com'),
(2542, 1290180024, 1, 'akilar123@googlemail.com'),
(2543, 1290180024, 1, 'gawainitahirahqy@gmail.com'),
(2544, 1290180024, 1, 'mervine49nielsen@yahoo.co.uk'),
(2545, 1290180024, 1, 'smithira21@yahoo.com'),
(2546, 1290180024, 1, 'sheidler.gilbert480@ymail.com'),
(2547, 1290180024, 1, 'forumpuss@yahoo.com'),
(2548, 1290180024, 1, 'nephiralough@gmail.com'),
(2549, 1290180024, 1, 'mwayne01@yahoo.com'),
(2550, 1290180024, 1, 'johnmakarenko@hotmail.com'),
(2551, 1290180024, 1, 'info@frontloadwasheranddryer.org'),
(2552, 1290180024, 1, 'luciefederrik@aol.com'),
(2553, 1290180024, 1, 'grant947@gmail.com'),
(2554, 1290180024, 1, 'carteregana@gmail.com'),
(2555, 1290180024, 1, 'bima9984@yahoo.com'),
(2556, 1290180024, 1, 'quijibohomer@gmail.com'),
(2557, 1290180024, 1, 'maraleonteva@gmail.com'),
(2558, 1290180024, 1, 'krishna_rajuu03@yahoo.com'),
(2559, 1290180024, 1, 'trafficsiphon8@yahoo.co.uk'),
(2560, 1290180024, 1, 'designlubna@gmail.com'),
(2561, 1290180024, 1, 'usman201008@yahoo.com'),
(2562, 1290180024, 1, 'supercontrol105@yahoo.com'),
(2563, 1290180024, 1, 'info@dreamdancerdesign.com'),
(2564, 1290180024, 1, 'bernettatojo825668@hotmail.com'),
(2565, 1290180024, 1, 'convertonet@gmail.com'),
(2566, 1290180024, 1, 'weightlossbox@gmail.com'),
(2567, 1290180024, 1, 'vanessa@firstlamedia.com'),
(2568, 1290180024, 1, 'reimer.geneviesm5@hotmail.com'),
(2569, 1290180024, 1, 'webmaster@obsidianvector.com'),
(2570, 1290180024, 1, 'speedupmycomputerfree@gmail.com'),
(2571, 1290180024, 1, 'kimcyrusilu@yahoo.com'),
(2572, 1290180024, 1, 'contact@likemyshare.com'),
(2573, 1290180024, 1, 'denisejohnson906@gmail.com'),
(2574, 1290180024, 1, 'mikesmith1566a@yahoo.com'),
(2575, 1290180024, 1, 'valasoll@gmail.com'),
(2576, 1290180024, 1, 'trastrap5@yahoo.com.cn'),
(2577, 1290180024, 1, 'abbie156@gmail.com'),
(2578, 1290180024, 1, 'duactuadiak@mail.ru'),
(2579, 1290180024, 1, 'goopxx11@yahoo.com'),
(2580, 1290180024, 1, 'abbie156@gmail.com'),
(2581, 1290180024, 1, 'gluazrdn@bolas-sob.co.cc'),
(2582, 1290180024, 1, 'ganjuman@yahoo.com'),
(2583, 1290180024, 1, 'devvickylegal@gmail.com'),
(2584, 1290180024, 1, '350779708@qq.com'),
(2585, 1290180024, 1, 'richardsuryajaya@gmail.com'),
(2586, 1290180024, 1, 'uniformmeet@sogou.com'),
(2587, 1290180024, 1, 'nastybellaya@gmail.com'),
(2588, 1290180024, 1, 'genrigetord@gmail.com'),
(2589, 1290180024, 1, 'nolan19bray@yahoo.co.uk'),
(2590, 1290180024, 1, 'teresogrone@gmail.com'),
(2591, 1290180024, 1, 'zabelin@involgu.ru'),
(2592, 1290180024, 1, 'bhuvanagokul1@gmail.com'),
(2593, 1290180024, 1, 'fashion2k10pro@yahoo.co.uk'),
(2594, 1290180024, 1, 'dgcasey.valliere2c@hotmail.com'),
(2595, 1290180024, 1, 'arnucha@googlemail.com'),
(2596, 1290180024, 1, 'smithed1982@gmail.com'),
(2597, 1290180024, 1, 'ballardrefugio609@gmail.com'),
(2598, 1290180024, 1, 'noinv86@gmail.com'),
(2599, 1290180024, 1, 'chadchau@ymail.com'),
(2600, 1290180024, 1, 'michaelzadel@gmail.com'),
(2601, 1290180024, 1, 'cellphoneguy7@loadransport.com'),
(2602, 1290180024, 1, 'sueisaiah455@gmail.com'),
(2603, 1290180024, 1, 'gallvorob@gmail.com'),
(2604, 1290180024, 1, 'ganjuman@yahoo.com'),
(2605, 1290180024, 1, 'dreamdays50@yahoo.com'),
(2606, 1290180024, 1, 'oldfroglet@aimbigatlife.com'),
(2607, 1290180024, 1, 'glacegrafixweb@yahoo.com'),
(2608, 1290180024, 1, 'bgraymergs4nylaii@hotmail.com'),
(2609, 1290180024, 1, 'marciebertolino@gmail.com'),
(2610, 1290180024, 1, 'kamagraforums@gmail.com'),
(2611, 1290180024, 1, 'alensolovushka@gmail.com'),
(2612, 1290180024, 1, 'tasana.colquittg@hotmail.com'),
(2613, 1290180024, 1, 'hallockfrcars@gmail.com'),
(2614, 1290180024, 1, 'rauchkvrelwandahgdw@hotmail.com'),
(2615, 1290180024, 1, 'johnbe3965@hotmail.com'),
(2616, 1290180024, 1, 'alensolovushka@gmail.com'),
(2617, 1290180024, 1, 'stimulatorcardiac@midoc.ro'),
(2618, 1290180024, 1, 'golftips2010@yahoo.cn'),
(2619, 1290180024, 1, 'malvaraluzer@gmail.com'),
(2620, 1290180024, 1, 'adrtechnology@gmail.com'),
(2621, 1290180024, 1, 'jordonlikins@hotmail.com'),
(2622, 1290180024, 1, 'coltchicken@aimbigatlife.com'),
(2623, 1290180024, 1, 'olloni.setserc@hotmail.com'),
(2624, 1290180024, 1, 'blondellabbenante951075@hotmail.com'),
(2625, 1290180024, 1, 'conceptionimlkemperp6zb@hotmail.com'),
(2626, 1290180024, 1, 'valkakotic@gmail.com'),
(2627, 1290180024, 1, 'blackhatboy1@gmail.com'),
(2628, 1290180024, 1, 'amioselvanto@gmail.com'),
(2629, 1290180024, 1, 'cresssgwqcorrinneuvy2@hotmail.com'),
(2630, 1290180024, 1, 'mrcpermondini7@gmail.com'),
(2631, 1290180024, 1, 'jamrising@yahoo.com'),
(2632, 1290180024, 1, 'lydiareyes35@gmail.com'),
(2633, 1290180024, 1, 'varaplod@gmail.com'),
(2634, 1290180024, 1, 'thompson44@live.com'),
(2635, 1290180024, 1, 'nycarson.evelindr@hotmail.com'),
(2636, 1290180024, 1, 'desmond38duncan@yahoo.co.uk'),
(2637, 1290180024, 1, 'vernongetzler@gmail.com'),
(2638, 1290180024, 1, 'israeler9roth@yahoo.co.uk'),
(2639, 1290180024, 1, 'bubuli.epoh@yahoo.com'),
(2640, 1290180024, 1, 'tristansoto216516@haltyourforeclosure.us'),
(2641, 1290180024, 1, 'fista@eurourl.net'),
(2642, 1290180024, 1, 'quijibomike@yahoo.co.uk'),
(2643, 1290180024, 1, 'jasonred0118@yahoo.com'),
(2644, 1290180024, 1, 'bananatobe1234@aol.com'),
(2645, 1290180024, 1, 'mariusjansen23@yahoo.com'),
(2646, 1290180024, 1, 'jasonred0118@yahoo.com'),
(2647, 1290180024, 1, 'mikeyardy@hotmail.com'),
(2648, 1290180024, 1, 'scsamuelconnolly@googlemail.com'),
(2649, 1290180024, 1, 'aldo22tate@saveyourmarriage.ws'),
(2650, 1290180024, 1, 'wordgames1@gmail.com'),
(2651, 1290180024, 1, 'forgegrrl@yahoo.co.uk'),
(2652, 1290180024, 1, 'minisa123@sinhvienct.com'),
(2653, 1290180024, 1, 'grover98sharp@yahoo.co.uk'),
(2654, 1290180024, 1, 'todd83cannon@aol.com'),
(2655, 1290180024, 1, 'goodtimesfornow90@yahoo.co.uk'),
(2656, 1290180024, 1, 'sean93summers@yahoo.co.uk'),
(2657, 1290180024, 1, 'julianmarble@gmail.com'),
(2658, 1290180024, 1, 'lord25078mejia@yahoo.co.uk'),
(2659, 1290180024, 1, 'thiesse_glen3031972@yahoo.com'),
(2660, 1290180024, 1, 'morgan061288@gmail.com'),
(2661, 1290180024, 1, 's_wolf1976s@yahoo.co.uk'),
(2662, 1290180024, 1, 'hophip820@gmail.com'),
(2663, 1290180024, 1, 'flashpapers@gmail.com'),
(2664, 1290180024, 1, 'nhealth02@yahoo.co.uk'),
(2665, 1290180024, 1, 'sarahpongonda@gmail.com'),
(2666, 1290180024, 1, 'panicaway1@hotmail.com'),
(2667, 1290180024, 1, 'iqmonikay2ncastanos@hotmail.com'),
(2668, 1290180024, 1, 'mcleandowel@hotmail.com'),
(2669, 1290180024, 1, 'bibileng@gmail.com'),
(2670, 1290180024, 1, 'haliagoli@gmail.com'),
(2671, 1290180024, 1, 'isidro94leach@yahoo.co.uk'),
(2672, 1290180024, 1, 'bjsybil.smithql@hotmail.com'),
(2673, 1290180024, 1, 'bobbie55allen@yahoo.co.uk'),
(2674, 1290180024, 1, 'marionmcleodyu@gmail.com'),
(2675, 1290180024, 1, 'markusfelm@gmail.com'),
(2676, 1290180024, 1, 'mitchelljohntion@hotmail.com'),
(2677, 1290180024, 1, 'jjones2444@gmail.com'),
(2678, 1290180024, 1, 'summerkathy86@yahoo.co.uk'),
(2679, 1290180024, 1, 'spamanager6@aol.com'),
(2680, 1290180024, 1, 'v9@mymailindex.com'),
(2681, 1290180024, 1, 'parsonsmax26@yahoo.com'),
(2682, 1290180024, 1, 'ujkuykendall.mackenzieb@hotmail.com'),
(2683, 1290180024, 1, 'wpsueanncsrenfroef5@hotmail.com'),
(2684, 1290180024, 1, 'glutenfreecookings@gmail.com'),
(2685, 1290180024, 1, 'mattharris999@live.com'),
(2686, 1290180024, 1, 'anitafabirola198@yahoo.co.uk'),
(2687, 1290180024, 1, 'lorretta.chewning6zg@hotmail.com'),
(2688, 1290180024, 1, 'deshsex@yahoo.com'),
(2689, 1290180024, 1, 'james31fisher@hotmail.com'),
(2690, 1290180024, 1, 'prestonuxwall@yahoo.co.uk'),
(2691, 1290180024, 1, 'oliviya10@yahoo.in'),
(2692, 1290180024, 1, 'christinamadison24@gmail.com'),
(2693, 1290180024, 1, 'bryon4joyce@yahoo.co.uk'),
(2694, 1290180024, 1, 'malysmokk@gmail.com'),
(2695, 1290180024, 1, 'jennifer25mathew@yahoo.co.uk'),
(2696, 1290180024, 1, 'jiedahuanxi425@hotmail.com'),
(2697, 1290180024, 1, 'helalashata786@gmail.com'),
(2698, 1290180024, 1, 'yghickok.eraa@hotmail.com'),
(2699, 1290180024, 1, 'postalannex76@yahoo.co.uk'),
(2700, 1290180024, 1, 'jrrickymartin@hotmail.com'),
(2701, 1290180024, 1, 'modeeling12@yahoo.com'),
(2702, 1290180024, 1, 'caizhengyi70568299@gmail.com'),
(2703, 1290180024, 1, 'jack400simon@aol.com'),
(2704, 1290180024, 1, 'jun2tier@yahoo.co.uk'),
(2705, 1290180024, 1, 'sssacramentoseo94@gmail.com'),
(2706, 1290180024, 1, 'power_his@yahoo.com'),
(2707, 1290180024, 1, 'denzildsouza789@gmail.com'),
(2708, 1290180024, 1, 'veronicadan123@gmail.com'),
(2709, 1290180336, 2, 'Richard Bradley'),
(2710, 1290180336, 2, 'reynaldo62kenned'),
(2711, 1290180336, 2, 'Strothe362'),
(2712, 1290180336, 2, 'annawerrner23'),
(2713, 1290180336, 2, 'KissingGames22'),
(2714, 1290180336, 2, 'vincentnivea25'),
(2715, 1290180336, 2, 'julik2511'),
(2716, 1290180336, 2, 'floyd54horn'),
(2717, 1290180336, 2, 'topgamerzt'),
(2718, 1290180336, 2, 'macluwis'),
(2719, 1290180336, 2, 'jamestgnrune'),
(2720, 1290180336, 2, 'ryan95daisy'),
(2721, 1290180336, 2, 'Hodge142'),
(2722, 1290180336, 2, 'limoardent'),
(2723, 1290180336, 2, 'nathan8holder'),
(2724, 1290180336, 2, 'oliver2gill'),
(2725, 1290180336, 2, 'marcel82brennan'),
(2726, 1290180336, 2, 'loren7riceX'),
(2727, 1290180336, 2, 'Lionmedieval52'),
(2728, 1290180336, 2, 'tok25seo'),
(2729, 1290180336, 2, 'armand94keller'),
(2730, 1290180336, 2, 'barristerbenjiman'),
(2731, 1290180336, 2, 'choyungTam'),
(2732, 1290180336, 2, 'steve12345'),
(2733, 1290180336, 2, 'tcindia123'),
(2734, 1290180336, 2, 'Elliprof2'),
(2735, 1290180336, 2, 'dryicemanufacturer'),
(2736, 1290180336, 2, 'byron3rivers'),
(2737, 1290180336, 2, 'Fishing'),
(2738, 1290180336, 2, 'ritobana'),
(2739, 1290180336, 2, 'tsr2004'),
(2740, 1290180336, 2, 'sanford79pickett'),
(2741, 1290180336, 2, 'topmeme'),
(2742, 1290180336, 2, 'stubborn203'),
(2743, 1290180336, 2, 'johnabraham'),
(2744, 1290180336, 2, 'trucksgame'),
(2745, 1290180336, 2, 'ela104'),
(2746, 1290180336, 2, 'bfidelaarchers'),
(2747, 1290180336, 2, 'greengadgets12'),
(2748, 1290180336, 2, 'okaygoods'),
(2749, 1290180336, 2, 'KaestnertIrish'),
(2750, 1290180336, 2, 'plastikkart'),
(2751, 1290180336, 2, 'christina38moran'),
(2752, 1290180336, 2, 'batterycharger12'),
(2753, 1290180336, 2, 'sleepapnearemedies'),
(2754, 1290180336, 2, 'pedro5carson'),
(2755, 1290180336, 2, 'SanDiegops'),
(2756, 1290180336, 2, 'stubborn202'),
(2757, 1290180336, 2, 'lylestevens99'),
(2758, 1290180336, 2, 'atlantaseodude77'),
(2759, 1290180336, 2, 'sv11parrish'),
(2760, 1290180336, 2, 'safews24'),
(2761, 1290180336, 2, 'bestmmorpg2010'),
(2762, 1290180336, 2, 'Packing01'),
(2763, 1290180336, 2, 'buford58atkins'),
(2764, 1290180336, 2, 'joaquin98harriso'),
(2765, 1290180336, 2, 'Tomandjerrygames'),
(2766, 1290180336, 2, 'kingofgamesdotnet'),
(2767, 1290180336, 2, 'oliviace'),
(2768, 1290180336, 2, 'Tjandamurra'),
(2769, 1290180336, 2, 'diana7sanders'),
(2770, 1290180336, 2, 'ela104'),
(2771, 1290180336, 2, 'Barbadosusa'),
(2772, 1290180336, 2, 'disneygame1'),
(2773, 1290180336, 2, 'benito6harrison'),
(2774, 1290180336, 2, 'MCCARTY21'),
(2775, 1290180336, 2, 'anbu2020'),
(2776, 1290180336, 2, 'joshzscott'),
(2777, 1290180336, 2, 'WurstRed24'),
(2778, 1290180336, 2, 'fletcher58knowle'),
(2779, 1290180336, 2, 'Dueterark'),
(2780, 1290180336, 2, 'lishiming1220'),
(2781, 1290180336, 2, 'maynard72blackwe'),
(2782, 1290180336, 2, 'Suraj85'),
(2783, 1290180336, 2, 'Karls597'),
(2784, 1290180336, 2, 'simektanizlefeca'),
(2785, 1290180336, 2, 'royce13wolfe'),
(2786, 1290180336, 2, 'Bubble_Wrap'),
(2787, 1290180336, 2, 'sunpay12'),
(2788, 1290180336, 2, 'ruisilva'),
(2789, 1290180336, 2, 'elo0oy'),
(2790, 1290180336, 2, 'franklinguy45'),
(2791, 1290180336, 2, 'andropenis909'),
(2792, 1290180336, 2, 'himash001'),
(2793, 1290180336, 2, 'blurayplayers'),
(2794, 1290180336, 2, 'shane watson'),
(2795, 1290180336, 2, 'capsiplex36'),
(2796, 1290180336, 2, 'bestreverse888'),
(2797, 1290180336, 2, 'Mary45CH'),
(2798, 1290180336, 2, 'greenrent'),
(2799, 1290180336, 2, 'workingmum'),
(2800, 1290180336, 2, 'bernarDceciliat'),
(2801, 1290180336, 2, 'burton78stephens'),
(2802, 1290180336, 2, 'Yingli'),
(2803, 1290180336, 2, 'hoodiafanchad'),
(2804, 1290180336, 2, 'medievalcodes55'),
(2805, 1290180336, 2, 'wartonmedieval22'),
(2806, 1290180336, 2, 'varou542'),
(2807, 1290180336, 2, 'kimwills43'),
(2808, 1290180336, 2, 'madietrey'),
(2809, 1290180336, 2, 'indirmedenfilmizle'),
(2810, 1290180336, 2, 'mrbooboo'),
(2811, 1290180336, 2, 'proudhairstyle4'),
(2812, 1290180336, 2, 'topsset45632'),
(2813, 1290180336, 2, 'jackie261allison'),
(2814, 1290180336, 2, 'mynetsohbet'),
(2815, 1290180336, 2, 'willie7rivera2'),
(2816, 1290180336, 2, 'delagpelna81'),
(2817, 1290180336, 2, 'vito33whitehead'),
(2818, 1290180336, 2, 'terence28gallego'),
(2819, 1290180336, 2, 'jamesvick'),
(2820, 1290180336, 2, 'yeastrol0301'),
(2821, 1290180336, 2, 'marandalawmarn10'),
(2822, 1290180336, 2, 'lane9levy6'),
(2823, 1290180336, 2, 'talyorisland80'),
(2824, 1290180336, 2, 'hoteltravelvietnam'),
(2825, 1290180336, 2, 'heath35landry'),
(2826, 1290180336, 2, 'iddaaiddia'),
(2827, 1290180336, 2, 'dougm6uhco'),
(2828, 1290180336, 2, 'arickdAlonly56'),
(2829, 1290180336, 2, 'studbig23'),
(2830, 1290180336, 2, 'petadoptions'),
(2831, 1290180336, 2, 'daryl96boyd'),
(2832, 1290180336, 2, 'forest38roberson'),
(2833, 1290180336, 2, 'rick48schaefer'),
(2834, 1290180336, 2, 'kleonmitt'),
(2835, 1290180336, 2, 'makemybaby3'),
(2836, 1290180336, 2, 'tiffannyy'),
(2837, 1290180336, 2, 'petadoptions'),
(2838, 1290180336, 2, 'virgil1sheppard'),
(2839, 1290180336, 2, 'Marco489'),
(2840, 1290180336, 2, 'beckiluckey333'),
(2841, 1290180336, 2, 'directory542'),
(2842, 1290180336, 2, 'bryce5tran'),
(2843, 1290180336, 2, 'ronald321T3'),
(2844, 1290180336, 2, 'bigzero0'),
(2845, 1290180336, 2, 'obestoma64'),
(2846, 1290180336, 2, 'grant43yang'),
(2847, 1290180336, 2, 'earl57marquez'),
(2848, 1290180336, 2, 'fullcontact22'),
(2849, 1290180336, 2, 'sonny1mcpherson'),
(2850, 1290180336, 2, 'lili79vardyz'),
(2851, 1290180336, 2, 'chris3mooney'),
(2852, 1290180336, 2, 'Annabella'),
(2853, 1290180336, 2, 'linda2davenport'),
(2854, 1290180336, 2, 'Munchenflughafen'),
(2855, 1290180336, 2, 'Kimberyo8aS7'),
(2856, 1290180336, 2, 'kylemaniaa'),
(2857, 1290180336, 2, 'vocalpeep17'),
(2858, 1290180336, 2, 'homeroad2'),
(2859, 1290180336, 2, 'P90XEquipment23'),
(2860, 1290180336, 2, 'danwestly01'),
(2861, 1290180336, 2, 'dewayne6y76nney'),
(2862, 1290180336, 2, 'glennokley'),
(2863, 1290180336, 2, 'benny4mills667'),
(2864, 1290180336, 2, 'lucy32Avante'),
(2865, 1290180336, 2, 'homeroad'),
(2866, 1290180336, 2, 'forledreviewss'),
(2867, 1290180336, 2, 'donald28key'),
(2868, 1290180336, 2, 'ronnyklein79'),
(2869, 1290180336, 2, 'norman7noble'),
(2870, 1290180336, 2, 'garland42hollowa'),
(2871, 1290180336, 2, 'rosalbameog82'),
(2872, 1290180336, 2, 'adolph517hendrick'),
(2873, 1290180336, 2, 'margarito92casey'),
(2874, 1290180336, 2, 'jimhawk9999'),
(2875, 1290180336, 2, 'phimsex'),
(2876, 1290180336, 2, 'tataersatzteile'),
(2877, 1290180336, 2, 'albertclothing08'),
(2878, 1290180336, 2, 'annie01'),
(2879, 1290180336, 2, 'lynnstowe12'),
(2880, 1290180336, 2, 'kutsiyos12'),
(2881, 1290180336, 2, 'gavaictuccalm'),
(2882, 1290180336, 2, 'joycemary6young'),
(2883, 1290180336, 2, 'carey68c0onner'),
(2884, 1290180336, 2, 'borg9stamiuz'),
(2885, 1290180336, 2, 'jason5678'),
(2886, 1290180336, 2, 'jonathan21marsh1'),
(2887, 1290180336, 2, 'aldovoughn'),
(2888, 1290180336, 2, 'winston75sloan'),
(2889, 1290180336, 2, 'terrence4blancha'),
(2890, 1290180336, 2, 'citizenlaw067'),
(2891, 1290180336, 2, 'jessie8silva'),
(2892, 1290180336, 2, 'smokingweedman'),
(2893, 1290180336, 2, 'wilderststudio'),
(2894, 1290180336, 2, 'shannon46kerr'),
(2895, 1290180336, 2, 'kentucky69yamma'),
(2896, 1290180336, 2, 'bernardo4dickson'),
(2897, 1290180336, 2, 'subway1983'),
(2898, 1290180336, 2, 'ralph17atkinson'),
(2899, 1290180336, 2, 'anthongarvela8'),
(2900, 1290180336, 2, 'denver53steele'),
(2901, 1290180336, 2, 'salomethomas27'),
(2902, 1290180336, 2, 'denzpertrison3'),
(2903, 1290180336, 2, 'darwin31potter'),
(2904, 1290180336, 2, 'worksreugenio'),
(2905, 1290180336, 2, 'alexander46serra'),
(2906, 1290180336, 2, 'alo3nzo4ngo7bui'),
(2907, 1290180336, 2, 'robertgreen666'),
(2908, 1290180336, 2, 'rodykowdelljr'),
(2909, 1290180336, 2, 'allejandoro97charl'),
(2910, 1290180336, 2, 'andyhoney'),
(2911, 1290180336, 2, 'carsparkinggames'),
(2912, 1290180336, 2, 'love52u'),
(2913, 1290180336, 2, 'Bioreaserma'),
(2914, 1290180336, 2, 'johnathon4brooks'),
(2915, 1290180336, 2, 'ariana01'),
(2916, 1290180336, 2, 'robertmaciejew13'),
(2917, 1290180336, 2, 'jame9klein324'),
(2918, 1290180336, 2, 'carpet34cleaning'),
(2919, 1290180336, 2, 'moises75best'),
(2920, 1290180336, 2, 'Iweas6'),
(2921, 1290180336, 2, 'asitnetwork28'),
(2922, 1290180336, 2, 'stepbrow2'),
(2923, 1290180336, 2, 'tatadeutschland'),
(2924, 1290180336, 2, 'gale55olsen'),
(2925, 1290180336, 2, 'chester19booker'),
(2926, 1290180336, 2, 'usedvanman1'),
(2927, 1290180336, 2, 'burton8sullivan'),
(2928, 1290180336, 2, 'menmypsp33'),
(2929, 1290180336, 2, 'frankg9corinna'),
(2930, 1290180336, 2, 'growlongereyelashes3'),
(2931, 1290180336, 2, 'growingeyelashes4'),
(2932, 1290180336, 2, 'besteyelashgrowth12'),
(2933, 1290180336, 2, 'GESolar'),
(2934, 1290180336, 2, 'lashgrowth5'),
(2935, 1290180336, 2, 'PoselennovSb'),
(2936, 1290180336, 2, 'blueberry0306'),
(2937, 1290180336, 2, 'armando4cooley'),
(2938, 1290180336, 2, 'joey15'),
(2939, 1290180336, 2, 'BrentonhMcculough324'),
(2940, 1290180336, 2, 'TeraLady'),
(2941, 1290180336, 2, 'darrellsparks44'),
(2942, 1290180336, 2, 'cashadvance91pa'),
(2943, 1290180336, 2, 'revolutionarymy'),
(2944, 1290180336, 2, 'faliano'),
(2945, 1290180336, 2, 'gcotton322'),
(2946, 1290180336, 2, 'fluingnofTuro03'),
(2947, 1290180336, 2, 'Evelina88Kanerva'),
(2948, 1290180336, 2, 'wombts'),
(2949, 1290180336, 2, 'ryanholloway86'),
(2950, 1290180336, 2, 'carpet37supplies'),
(2951, 1290180336, 2, 'harrison9rice'),
(2952, 1290180336, 2, 'program0optimizer8'),
(2953, 1290180336, 2, 'ian6luna'),
(2954, 1290180336, 2, 'salimhawk'),
(2955, 1290180336, 2, 'mscleansing'),
(2956, 1290180336, 2, 'AuropicaGT'),
(2957, 1290180336, 2, 'julie7stokes'),
(2958, 1290180336, 2, 'GumuFedeKokais'),
(2959, 1290180336, 2, 'williamhowards34'),
(2960, 1290180336, 2, '1bob2farmer24'),
(2961, 1290180336, 2, 'k9detectiondogs'),
(2962, 1290180336, 2, 'pedr4o58carey'),
(2963, 1290180336, 2, 'mobiledistributionsol'),
(2964, 1290180336, 2, 'suse28huber'),
(2965, 1290180336, 2, 'bloggergill7d8ipadilla'),
(2966, 1290180336, 2, 'Jamie0023'),
(2967, 1290180336, 2, 'siovenybitvy'),
(2968, 1290180336, 2, 'walter22zimmerman'),
(2969, 1290180336, 2, 'versumo8'),
(2970, 1290180336, 2, 'dainrisy'),
(2971, 1290180336, 2, 'quizzicalcanoe5'),
(2972, 1290180336, 2, 'rusty7baird'),
(2973, 1290180336, 2, 'dion8potts'),
(2974, 1290180336, 2, 'brent6marks'),
(2975, 1290180336, 2, 'jamgera1962'),
(2976, 1290180336, 2, 'wardafTab'),
(2977, 1290180336, 2, 'monassirah1980'),
(2978, 1290180336, 2, 'merle4stewart'),
(2979, 1290180336, 2, 'haryoseo'),
(2980, 1290180336, 2, 'gwerder81'),
(2981, 1290180336, 2, 'ted'),
(2982, 1290180336, 2, 'differenttime10'),
(2983, 1290180336, 2, 'nelsoncarrillo033993'),
(2984, 1290180336, 2, 'donnie4mcknight'),
(2985, 1290180336, 2, 'Tunks70'),
(2986, 1290180336, 2, 'curt64sykes'),
(2987, 1290180336, 2, 'howard14mathis'),
(2988, 1290180336, 2, 'frank5battery'),
(2989, 1290180336, 2, 'tom12345'),
(2990, 1290180336, 2, 'sandypark'),
(2991, 1290180336, 2, 'dusty8andrews'),
(2992, 1290180336, 2, 'shagun10'),
(2993, 1290180336, 2, 'pampergirl'),
(2994, 1290180336, 2, 'earlfoley4711'),
(2995, 1290180336, 2, 'marshall52campbe'),
(2996, 1290180336, 2, 'links014'),
(2997, 1290180336, 2, 'bradford43moreno'),
(2998, 1290180336, 2, 'billy10388'),
(2999, 1290180336, 2, 'mordi26welch'),
(3000, 1290180336, 2, 'SaladRevolution'),
(3001, 1290180336, 2, 'sue74clark'),
(3002, 1290180336, 2, 'greendiyenergy'),
(3003, 1290180336, 2, 'parker95gonzalez'),
(3004, 1290180336, 2, 'doyle84strong'),
(3005, 1290180336, 2, 'jacob19porter'),
(3006, 1290180336, 2, 'Hick32'),
(3007, 1290180336, 2, 'wilson5wiley'),
(3008, 1290180336, 2, 'fconcepts10'),
(3009, 1290180336, 2, 'shawnflanery78'),
(3010, 1290180336, 2, 'melvinopmolina'),
(3011, 1290180336, 2, 'nercus32lohen'),
(3012, 1290180336, 2, 'jesus8haney'),
(3013, 1290180336, 2, 'earl58burnett'),
(3014, 1290180336, 2, 'ali.nelson21g'),
(3015, 1290180336, 2, 'jamie24combs'),
(3016, 1290180336, 2, 'andiaso'),
(3017, 1290180336, 2, 'slxo59user'),
(3018, 1290180336, 2, 'streamingdemon'),
(3019, 1290180336, 2, 'bobby124burnett'),
(3020, 1290180336, 2, 'zachary4navarro'),
(3021, 1290180336, 2, 'chris44delaney'),
(3022, 1290180336, 2, 'stamper89'),
(3023, 1290180336, 2, 'alitas'),
(3024, 1290180336, 2, 'moaningtact99'),
(3025, 1290180336, 2, 'kenneth79travis'),
(3026, 1290180336, 2, 'JamesCConant'),
(3027, 1290180336, 2, 'carlmiller'),
(3028, 1290180336, 2, 'ModernDiva'),
(3029, 1290180336, 2, 'dmoseley78'),
(3030, 1290180336, 2, 'keepthefaith'),
(3031, 1290180336, 2, 'Chlupitzer'),
(3032, 1290180336, 2, 'AndiBerger81'),
(3033, 1290180336, 2, 'mareta123'),
(3034, 1290180336, 2, 'moses2cook'),
(3035, 1290180336, 2, 'AdsTricks'),
(3036, 1290180336, 2, 'Buttercup'),
(3037, 1290180336, 2, 'Arcalrylibbit'),
(3038, 1290180336, 2, 'JarFernebar'),
(3039, 1290180336, 2, 'awaPeLigrig'),
(3040, 1290180336, 2, 'Assusewergied'),
(3041, 1290180336, 2, 'LogKegomeft'),
(3042, 1290180336, 2, 'emipiexassist'),
(3043, 1290180336, 2, 'Erurtubre'),
(3044, 1290180336, 2, 'Shoutsexets'),
(3045, 1290180336, 2, 'GuefSmumb'),
(3046, 1290180336, 2, 'Unduccado'),
(3047, 1290180336, 2, 'trittycix'),
(3048, 1290180336, 2, 'hotafrorTaw'),
(3049, 1290180336, 2, 'anaennyLerhek'),
(3050, 1290180336, 2, 'vellituermimi'),
(3051, 1290180336, 2, 'ZelfMogereigo'),
(3052, 1290180336, 2, 'Swepifienue'),
(3053, 1290180336, 2, 'bribriyo'),
(3054, 1290180336, 2, 'Apparfavecrek'),
(3055, 1290180336, 2, 'cannabis4xan'),
(3056, 1290180336, 2, 'Gosquespoopay'),
(3057, 1290180336, 2, 'Assusewergied'),
(3058, 1290180336, 2, 'dipoamusst'),
(3059, 1290180336, 2, 'Easemnnen'),
(3060, 1290180336, 2, 'chinese0201'),
(3061, 1290180336, 2, 'babylissceramic'),
(3062, 1290180336, 2, 'gingergaltina9090'),
(3063, 1290180336, 2, 'rehman9901'),
(3064, 1290180336, 2, 'francisco33patel'),
(3065, 1290180336, 2, 'lorenzo56james'),
(3066, 1290180336, 2, 'ruddypoody'),
(3067, 1290180336, 2, 'Earache99'),
(3068, 1290180336, 2, 'chris827'),
(3069, 1290180336, 2, 'belladaykin'),
(3070, 1290180336, 2, 'lawrence801hicks'),
(3071, 1290180336, 2, 'lucas54mills'),
(3072, 1290180336, 2, 'Reuben894'),
(3073, 1290180336, 2, 'numnutz2005'),
(3074, 1290180336, 2, 'hunter94parks'),
(3075, 1290180336, 2, 'garry73morales'),
(3076, 1290180336, 2, 'fred4horton'),
(3077, 1290180336, 2, 'draclaudiaromero2010'),
(3078, 1290180336, 2, 'buxom'),
(3079, 1290180336, 2, 'yanniraz'),
(3080, 1290180336, 2, 'Carter22Christian'),
(3081, 1290180336, 2, 'alfonso4563ramirez'),
(3082, 1290180336, 2, 'russscottie1rice'),
(3083, 1290180336, 2, 'wetdealer26'),
(3084, 1290180336, 2, 'abrehong'),
(3085, 1290180336, 2, 'jelltine9'),
(3086, 1290180336, 2, 'atkinsrecipes04'),
(3087, 1290180336, 2, 'billiethefloorguy'),
(3088, 1290180336, 2, 'Javea_villa_rental_guy'),
(3089, 1290180336, 2, 'jeremy5wade'),
(3090, 1290180336, 2, 'young7barnett'),
(3091, 1290180336, 2, 'gamerparadise'),
(3092, 1290180336, 2, 'kiethhester1'),
(3093, 1290180336, 2, 'da37'),
(3094, 1290180336, 2, 'divaKp3'),
(3095, 1290180336, 2, 'swulff85'),
(3096, 1290180336, 2, 'fredfuna'),
(3097, 1290180336, 2, 'antoncarpenter73'),
(3098, 1290180336, 2, 'oreo17'),
(3099, 1290180336, 2, 'lirianomary'),
(3100, 1290180336, 2, 'claudiaSD'),
(3101, 1290180336, 2, 'body8tattoo'),
(3102, 1290180336, 2, 'robertsheltonn7483'),
(3103, 1290180336, 2, 'rigoberto2terrel'),
(3104, 1290180336, 2, 'sergio65gordon'),
(3105, 1290180336, 2, 'sebastian3lamber'),
(3106, 1290180336, 2, 'health4world'),
(3107, 1290180336, 2, 'shaun65hodge'),
(3108, 1290180336, 2, 'wmurphy81'),
(3109, 1290180336, 2, 'mohsintal'),
(3110, 1290180336, 2, 'goteborg12345'),
(3111, 1290180336, 2, 'choyie28'),
(3112, 1290180336, 2, 'pdefmdef123'),
(3113, 1290180336, 2, 'alfie2010'),
(3114, 1290180336, 2, 'traveliron36'),
(3115, 1290180336, 2, 'EsthetiqueMaroc'),
(3116, 1290180336, 2, 'daren18frazier'),
(3117, 1290180336, 2, 'ga2vin82da1nga'),
(3118, 1290180336, 2, 'jahnzz123'),
(3119, 1290180336, 2, 'iJRathore'),
(3120, 1290180336, 2, 'alex weber'),
(3121, 1290180336, 2, 'goran32bour'),
(3122, 1290180336, 2, 'implantdentist33'),
(3123, 1290180336, 2, 'lpgautogas'),
(3124, 1290180336, 2, 'timmy69bishop'),
(3125, 1290180336, 2, 'lorisutton444'),
(3126, 1290180336, 2, 'jojo1206'),
(3127, 1290180336, 2, 'wysdon12'),
(3128, 1290180336, 2, 'mike45gates'),
(3129, 1290180336, 2, 'ZwinkysDownload48'),
(3130, 1290180336, 2, 'dalton83britt'),
(3131, 1290180336, 2, 'spencer1uolsen'),
(3132, 1290180336, 2, 'marcus91ray'),
(3133, 1290180336, 2, 'ted69weiss'),
(3134, 1290180336, 2, 'rodrigo4mcintyre'),
(3135, 1290180336, 2, 'PrettyFan'),
(3136, 1290180336, 2, 'pwsslick'),
(3137, 1290180336, 2, 'howtohackfacebookx'),
(3138, 1290180336, 2, 'ashley6597'),
(3139, 1290180336, 2, 'jacques2coffey'),
(3140, 1290180336, 2, 'magalufhotels10'),
(3141, 1290180336, 2, 'tim63lane'),
(3142, 1290180336, 2, 'LaptopsNotebooks'),
(3143, 1290180336, 2, 'gnzi828'),
(3144, 1290180336, 2, 'chunkyfactory90'),
(3145, 1290180336, 2, 'legalmoviesites'),
(3146, 1290180336, 2, 'stuartkaufmanbiz7861'),
(3147, 1290180336, 2, 'ErnestColumbus'),
(3148, 1290180336, 2, 'wlunsford03'),
(3149, 1290180336, 2, 'julie6andrews'),
(3150, 1290180336, 2, 'darrel77hester'),
(3151, 1290180336, 2, 'a.meldrum'),
(3152, 1290180336, 2, 'herman41wagner'),
(3153, 1290180336, 2, 'FootballDoony'),
(3154, 1290180336, 2, 'davidzz0551'),
(3155, 1290180336, 2, 'Quinlan'),
(3156, 1290180336, 2, 'griffj1980'),
(3157, 1290180336, 2, 'aseaborn83'),
(3158, 1290180336, 2, 'Colemanb8'),
(3159, 1290180336, 2, 'Moore458'),
(3160, 1290180336, 2, 'jayjayhenrySEMguru3871'),
(3161, 1290180336, 2, 'nerssmokeless'),
(3162, 1290180336, 2, 'carpet84cleaning'),
(3163, 1290180336, 2, 'les459ramsey'),
(3164, 1290180336, 2, 'kent81kerr'),
(3165, 1290180336, 2, 'mezitli190545'),
(3166, 1290180336, 2, 'micheal728'),
(3167, 1290180336, 2, 'cxush37777'),
(3168, 1290180336, 2, 'cheshremstot'),
(3169, 1290180336, 2, 'barton8emerson'),
(3170, 1290180336, 2, 'webgraphic'),
(3171, 1290180336, 2, 'disneyg01'),
(3172, 1290180336, 2, 'johncnly'),
(3173, 1290180336, 2, 'condaunuae'),
(3174, 1290180336, 2, 'machinepit'),
(3175, 1290180336, 2, 'edmond42dillard'),
(3176, 1290180336, 2, 'dorabootex'),
(3177, 1290180336, 2, 'bestguitars2buy'),
(3178, 1290180336, 2, 'miren'),
(3179, 1290180336, 2, 'opirtycot'),
(3180, 1290180336, 2, 'diet coffee'),
(3181, 1290180336, 2, 'businessguyJohnnie'),
(3182, 1290180336, 2, 'iluv2sing28'),
(3183, 1290180336, 2, 'intermarketingsite101'),
(3184, 1290180336, 2, 'ron6moran'),
(3185, 1290180336, 2, 'overeasy1'),
(3186, 1290180336, 2, 'merlin11bates'),
(3187, 1290180336, 2, 'amilligan78'),
(3188, 1290180336, 2, 'wyatt8mclaughlin'),
(3189, 1290180336, 2, 'bradley22gilmore'),
(3190, 1290180336, 2, 'aroomark'),
(3191, 1290180336, 2, 'mark1000'),
(3192, 1290180336, 2, 'chrisadam2'),
(3193, 1290180336, 2, 'hostgatorplan');
INSERT INTO `#__sl_SpamFilter` (`id`, `time`, `type`, `term`) VALUES
(3194, 1290180336, 2, 'patjeremy79'),
(3195, 1290180336, 2, 'sultangebet202'),
(3196, 1290180336, 2, 'bo3cake9hawk'),
(3197, 1290180336, 2, 'ruben84palmer'),
(3198, 1290180336, 2, 'pilu2511'),
(3199, 1290180336, 2, 'iPhone4gsmopmaat'),
(3200, 1290180336, 2, 'hira977'),
(3201, 1290180336, 2, 'MarshmallowPervert'),
(3202, 1290180336, 2, 'aying182'),
(3203, 1290180336, 2, 'stevenson7lamuel'),
(3204, 1290180336, 2, 'roland52valencia'),
(3205, 1290180336, 2, 'jamieholi882'),
(3206, 1290180336, 2, 'hung71charles'),
(3207, 1290180336, 2, 'jodf67penny'),
(3208, 1290180336, 2, 'brooks95lindsey'),
(3209, 1290180336, 2, 'brooks95lindsey'),
(3210, 1290180336, 2, 'duane22reid'),
(3211, 1290180336, 2, 'cheann'),
(3212, 1290180336, 2, 'fira19'),
(3213, 1290180336, 2, 'mauro86bonilla'),
(3214, 1290180336, 2, 'matthew49downs'),
(3215, 1290180336, 2, 'ovallfearl'),
(3216, 1290180336, 2, 'potentialjoe947'),
(3217, 1290180336, 2, 'wadegiles634'),
(3218, 1290180336, 2, 'duanereid731'),
(3219, 1290180336, 2, 'wildflower772'),
(3220, 1290180336, 2, 'brianthevirus'),
(3221, 1290180336, 2, 'myronxbox360'),
(3222, 1290180336, 2, 'doubleglazingderek'),
(3223, 1290180336, 2, 'doctorjones1'),
(3224, 1290180336, 2, 'owen94ruiz'),
(3225, 1290180336, 2, 'carpetc38leaner'),
(3226, 1290180336, 2, 'itechboy'),
(3227, 1290180336, 2, 'alan8grant'),
(3228, 1290180336, 2, 'Jarnno2563'),
(3229, 1290180336, 2, 'gil58petersen'),
(3230, 1290180336, 2, 'choppertattoox1'),
(3231, 1290180336, 2, 'elmer254decker'),
(3232, 1290180336, 2, 'leonard53sawyer'),
(3233, 1290180336, 2, 'benny8rivas'),
(3234, 1290180336, 2, 'gerald19jefferso'),
(3235, 1290180336, 2, 'glen18singleton'),
(3236, 1290180336, 2, 'donnie1barnes'),
(3237, 1290180336, 2, 'lillyjohns34'),
(3238, 1290180336, 2, 'darrin58davidson'),
(3239, 1290180336, 2, 'maynard9zamora'),
(3240, 1290180336, 2, 'zachary3lee'),
(3241, 1290180336, 2, 'mbarbour85'),
(3242, 1290180336, 2, 'whopnowe'),
(3243, 1290180336, 2, 'OglesVictogetru'),
(3244, 1290180336, 2, 'Penolope'),
(3245, 1290180336, 2, '4DCrapper'),
(3246, 1290180336, 2, 'bostonmarketguyz'),
(3247, 1290180336, 2, 'lindsey7mullen'),
(3248, 1290180336, 2, 'ali55kline'),
(3249, 1290180336, 2, 'owen18compton'),
(3250, 1290180336, 2, 'pbayne83'),
(3251, 1290180336, 2, 'loseweightteam2'),
(3252, 1290180336, 2, 'DharmayuPurohit'),
(3253, 1290180336, 2, 'ivory5long'),
(3254, 1290180336, 2, 'ashley14bradshaw'),
(3255, 1290180336, 2, 'kennith27carney'),
(3256, 1290180336, 2, 'himmler123'),
(3257, 1290180336, 2, 'madridjomel'),
(3258, 1290180336, 2, 'fimo999'),
(3259, 1290180336, 2, 'jesus83dominguez'),
(3260, 1290180336, 2, 'windowsblack101'),
(3261, 1290180336, 2, 'jane_bailey'),
(3262, 1290180336, 2, 'vincent44murray'),
(3263, 1290180336, 2, 'DWillks59'),
(3264, 1290180336, 2, 'arthur11brady'),
(3265, 1290180336, 2, 'jhulbert81'),
(3266, 1290180336, 2, 'kenny13maldonado'),
(3267, 1290180336, 2, 'gerald8simpson'),
(3268, 1290180336, 2, 'nelsongentry1977'),
(3269, 1290180336, 2, 'johnnie73'),
(3270, 1290180336, 2, 'AdsTricks'),
(3271, 1290180336, 2, 'jackson45'),
(3272, 1290180336, 2, 'kimasar50'),
(3273, 1290180336, 2, 'drivinggames'),
(3274, 1290180336, 2, 'harry_den'),
(3275, 1290180336, 2, 'getridofpe'),
(3276, 1290180336, 2, 'jaime91bartlett'),
(3277, 1290180336, 2, 'emmanuel51cooley'),
(3278, 1290180336, 2, 'chuck67church'),
(3279, 1290180336, 2, 'emmanuel51cooley'),
(3280, 1290180336, 2, 'UnwantedHairSolution'),
(3281, 1290180336, 2, 'gvincent82'),
(3282, 1290180336, 2, 'alberto16moss'),
(3283, 1290180336, 2, 'wild_fan'),
(3284, 1290180336, 2, 'bobbie8kaju'),
(3285, 1290180336, 2, 'kattz'),
(3286, 1290180336, 2, 'laverne26rodgers'),
(3287, 1290180336, 2, 'dhoutlet'),
(3288, 1290180336, 2, 'abase013'),
(3289, 1290180336, 2, 'pavery3warnerx'),
(3290, 1290180336, 2, 'eartus'),
(3291, 1290180336, 2, 'dalewhiting1275'),
(3292, 1290180336, 2, 'ron66fitzpatrick'),
(3293, 1290180336, 2, 'seoguy305'),
(3294, 1290180336, 2, 'logan9norris'),
(3295, 1290180336, 2, 'carpet19supplies'),
(3296, 1290180336, 2, 'kaizen1site'),
(3297, 1290180336, 2, 'alfonso72monroe'),
(3298, 1290180336, 2, 'dexters7mendoza'),
(3299, 1290180336, 2, 'amanamicrowave12'),
(3300, 1290180336, 2, 'sylvester312'),
(3301, 1290180336, 2, 'hollisticpremenopause'),
(3302, 1290180336, 2, 'jacqupacchi23'),
(3303, 1290180336, 2, 'jerome81noel'),
(3304, 1290180336, 2, 'justin007bieber'),
(3305, 1290180336, 2, 'KennethPoynter1'),
(3306, 1290180336, 2, 'gavin36pollard'),
(3307, 1290180336, 2, 'mary38sykes'),
(3308, 1290180336, 2, 'morgan6lambert'),
(3309, 1290180336, 2, 'Tech3Outcast'),
(3310, 1290180336, 2, 'homeloanratesguy22'),
(3311, 1290180336, 2, 'chad49herrera'),
(3312, 1290180336, 2, 'mike6ashmax'),
(3313, 1290180336, 2, 'edgarcayce'),
(3314, 1290180336, 2, 'friendadder'),
(3315, 1290180336, 2, 'gmchugh83'),
(3316, 1290180336, 2, 'yellowrfre32'),
(3317, 1290180336, 2, 'nathan35watts'),
(3318, 1290180336, 2, 'michel92york'),
(3319, 1290180336, 2, 'buman9valencia'),
(3320, 1290180336, 2, 'dean17strickland'),
(3321, 1290180336, 2, 'martincerrudo201'),
(3322, 1290180336, 2, 'stacey89workman'),
(3323, 1290180336, 2, 'admn0130'),
(3324, 1290180336, 2, 'melinamoore373'),
(3325, 1290180336, 2, 'esteeruiz'),
(3326, 1290180336, 2, 'Cr4ig'),
(3327, 1290180336, 2, 'jaysondiaz'),
(3328, 1290180336, 2, 'cureyourdisese102'),
(3329, 1290180336, 2, 'thailandedu'),
(3330, 1290180336, 2, 'gil19roberts'),
(3331, 1290180336, 2, 'corey6lester'),
(3332, 1290180336, 2, 'Villagetransportation'),
(3333, 1290180336, 2, 'p90xkarr58466'),
(3334, 1290180336, 2, 'muloffshore'),
(3335, 1290180336, 2, 'a1pressure804'),
(3336, 1290180336, 2, 'UKDirectorySubmitter'),
(3337, 1290180336, 2, 'leeaitkin'),
(3338, 1290180336, 2, 'jese2sie54dumuc'),
(3339, 1290180336, 2, 'Kinrton479'),
(3340, 1290180336, 2, 'markhurd1'),
(3341, 1290180336, 2, 'lee54ware'),
(3342, 1290180336, 2, 'personalinjuryclermont7'),
(3343, 1290180336, 2, 'robertpotter44'),
(3344, 1290180336, 2, 'donny43colon'),
(3345, 1290180336, 2, 'amberparker46'),
(3346, 1290180336, 2, 'alvin39caruso'),
(3347, 1290180336, 2, 'stewart142'),
(3348, 1290180336, 2, 'familyguy'),
(3349, 1290180336, 2, 'alvin000'),
(3350, 1290180336, 2, 'ryan76mccormick'),
(3351, 1290180336, 2, 'judifarmer22'),
(3352, 1290180336, 2, 'clinton58nixon'),
(3353, 1290180336, 2, 'amanamig98'),
(3354, 1290180336, 2, 'ravi7'),
(3355, 1290180336, 2, 'steveharringto210'),
(3356, 1290180336, 2, 'Nathaniel1'),
(3357, 1290180336, 2, 'visitjt21'),
(3358, 1290180336, 2, 'jkintons'),
(3359, 1290180336, 2, 'jarvis77paul'),
(3360, 1290180336, 2, 'Articles'),
(3361, 1290180336, 2, 'joseph29pope'),
(3362, 1290180336, 2, 'alden4collins'),
(3363, 1290180336, 2, 'freemankirklan78'),
(3364, 1290180336, 2, 'jorge4castaneda'),
(3365, 1290180336, 2, 'wowcataclysmdude'),
(3366, 1290180336, 2, 'jerrod1gray'),
(3367, 1290180336, 2, 'randolphmason201'),
(3368, 1290180336, 2, 'jarvisprestonttk'),
(3369, 1290180336, 2, 'hannah19'),
(3370, 1290180336, 2, 'daveracers'),
(3371, 1290180336, 2, 'tottipetra'),
(3372, 1290180336, 2, 'Yerish336'),
(3373, 1290180336, 2, 'Kelsoe937'),
(3374, 1290180336, 2, 'fecabook'),
(3375, 1290180336, 2, 'Serdgha105'),
(3376, 1290180336, 2, 'roberto9hutchins'),
(3377, 1290180336, 2, 'stevecakko'),
(3378, 1290180336, 2, 'ted56oliver'),
(3379, 1290180336, 2, 'hotell89'),
(3380, 1290180336, 2, 'blake6vinson'),
(3381, 1290180336, 2, 'policytime'),
(3382, 1290180336, 2, 'teddy79chaney'),
(3383, 1290180336, 2, 'wbrackett50'),
(3384, 1290180336, 2, 'rickie48tillman'),
(3385, 1290180336, 2, 'ernesto77anthony'),
(3386, 1290180336, 2, 'dedicatedpromo'),
(3387, 1290180336, 2, 'johncina'),
(3388, 1290180336, 2, 'axprovn'),
(3389, 1290180336, 2, 'Diablo3Beta'),
(3390, 1290180336, 2, 'snakesasa'),
(3391, 1290180336, 2, 'howtosing9'),
(3392, 1290180336, 2, 'CyberSeth'),
(3393, 1290180336, 2, 'kurtis4wong'),
(3394, 1290180336, 2, 'wilmer9snyder999'),
(3395, 1290180336, 2, 'juan49frank'),
(3396, 1290180336, 2, 'booker69melendez'),
(3397, 1290180336, 2, 'jcanning84'),
(3398, 1290180336, 2, 'trenton39trujill'),
(3399, 1290180336, 2, 'hardwood1'),
(3400, 1290180336, 2, 'dcwebdesigners'),
(3401, 1290180336, 2, 'mississauga59'),
(3402, 1290180336, 2, 'tonyde1'),
(3403, 1290180336, 2, 'Billigerparken'),
(3404, 1290180336, 2, 'perimenopauseweightgain'),
(3405, 1290180336, 2, 'normand3murphy'),
(3406, 1290180336, 2, 'carla80'),
(3407, 1290180336, 2, 'parkenmunchenflughafen'),
(3408, 1290180336, 2, 'MistyCat772'),
(3409, 1290180336, 2, 'Billigerflughafen'),
(3410, 1290180336, 2, 'graham24ortega'),
(3411, 1290180336, 2, 'towerssdefense'),
(3412, 1290180336, 2, 'edgarcayce'),
(3413, 1290180336, 2, 'garycwmq76'),
(3414, 1290180336, 2, 'merlin3cooke'),
(3415, 1290180336, 2, 'glen6day'),
(3416, 1290180336, 2, 'lughafenparken'),
(3417, 1290180336, 2, 'dante6miranda'),
(3418, 1290180336, 2, 'lichteer'),
(3419, 1290180336, 2, 'watch7twilight'),
(3420, 1290180336, 2, 'kirk76middleton'),
(3421, 1290180336, 2, '7aucktours'),
(3422, 1290180336, 2, 'moduleefficiency'),
(3423, 1290180336, 2, 'brianyost810'),
(3424, 1290180336, 2, 'reinaldophelps23'),
(3425, 1290180336, 2, 'cncschneiden'),
(3426, 1290180336, 2, 'gary52diaz'),
(3427, 1290180336, 2, 'Ejoboi64'),
(3428, 1290180336, 2, 'ogrames83'),
(3429, 1290180336, 2, 'johnny6pate'),
(3430, 1290180336, 2, 'buddy9rowe'),
(3431, 1290180336, 2, 'rigoberto79terre'),
(3432, 1290180336, 2, 'creativemind09'),
(3433, 1290180336, 2, 'rory21armstrong'),
(3434, 1290180336, 2, 'success'),
(3435, 1290180336, 2, 'SanDiegoEstatePlanning45'),
(3436, 1290180336, 2, 'eminemru48'),
(3437, 1290180336, 2, 'gregory21klein'),
(3438, 1290180336, 2, 'luise3patterson'),
(3439, 1290180336, 2, 'macbookshop'),
(3440, 1290180336, 2, 'ellis65welch'),
(3441, 1290180336, 2, 'luise3patterson'),
(3442, 1290180336, 2, 'bobmarleyclothing'),
(3443, 1290180336, 2, 'photovoltaic'),
(3444, 1290180336, 2, 'patrick36french'),
(3445, 1290180336, 2, 'irwin77howe'),
(3446, 1290180336, 2, 'sidneylammi'),
(3447, 1290180336, 2, 'Sally'),
(3448, 1290180336, 2, 'alton7porter'),
(3449, 1290180336, 2, 'petinsurance'),
(3450, 1290180336, 2, 'goyang'),
(3451, 1290180336, 2, 'phillipolunad'),
(3452, 1290180336, 2, 'eddyjabre123'),
(3453, 1290180336, 2, 'Maxwelli1Faggard'),
(3454, 1290180336, 2, 'allnaturalcleaning'),
(3455, 1290180336, 2, 'tuni3buzz'),
(3456, 1290180336, 2, 'markinverner21'),
(3457, 1290180336, 2, 'naturalsleepaid'),
(3458, 1290180336, 2, 'JamesDelgado'),
(3459, 1290180336, 2, 'belsmokeless'),
(3460, 1290180336, 2, 'elliott44harmon'),
(3461, 1290180336, 2, 'ernie62ashmax'),
(3462, 1290180336, 2, 'andres82marshall'),
(3463, 1290180336, 2, 'pouzee2511'),
(3464, 1290180336, 2, 'greenkorvk'),
(3465, 1290180336, 2, 'shannon82ross'),
(3466, 1290180336, 2, 'dan76clark'),
(3467, 1290180336, 2, 'emmett55whitley'),
(3468, 1290180336, 2, 'billythorton3572'),
(3469, 1290180336, 2, 'dion9potts92'),
(3470, 1290180336, 2, 'toaccess'),
(3471, 1290180336, 2, 'korvoozoy'),
(3472, 1290180336, 2, 'pasquale4bartlet'),
(3473, 1290180336, 2, 'ervin42stafford'),
(3474, 1290180336, 2, 'willis2ellis'),
(3475, 1290180336, 2, 'MallorcaMietwagen'),
(3476, 1290180336, 2, 'jorgeclam'),
(3477, 1290180336, 2, 'pornosins'),
(3478, 1290180336, 2, 'sexxiebebe23'),
(3479, 1290180336, 2, 'liosmuscles'),
(3480, 1290180336, 2, 'altamiraweb'),
(3481, 1290180336, 2, 'credol4296'),
(3482, 1290180336, 2, 'moonmaria94'),
(3483, 1290180336, 2, 'debtrelief'),
(3484, 1290180336, 2, 'reed75gregory'),
(3485, 1290180336, 2, 'ilmughaib'),
(3486, 1290180336, 2, 'galett11gill'),
(3487, 1290180336, 2, 'Romson'),
(3488, 1290180336, 2, 'phillip19fuentes'),
(3489, 1290180336, 2, 'vince74clements'),
(3490, 1290180336, 2, 'lavern98strickla'),
(3491, 1290180336, 2, 'otto99french'),
(3492, 1290180336, 2, 'kasiackrit123'),
(3493, 1290180336, 2, 'pooFoo'),
(3494, 1290180336, 2, 'milawakorvz'),
(3495, 1290180336, 2, 'johnchristopher'),
(3496, 1290180336, 2, 'taxidermy'),
(3497, 1290180336, 2, 'footballfan'),
(3498, 1290180336, 2, 'jasongilparker'),
(3499, 1290180336, 2, 'carrolkorv'),
(3500, 1290180336, 2, 'arrowng47'),
(3501, 1290180336, 2, 'errol86baldwin'),
(3502, 1290180336, 2, 'norris36sanders'),
(3503, 1290180336, 2, 'jonathon36howe'),
(3504, 1290180336, 2, 'belabron'),
(3505, 1290180336, 2, 'Oram33'),
(3506, 1290180336, 2, 'angelgomez143'),
(3507, 1290180336, 2, 'charlie66up'),
(3508, 1290180336, 2, 'percy25day'),
(3509, 1290180336, 2, 'lisawillinga25'),
(3510, 1290180336, 2, 'h2rsh4l8ad1ms'),
(3511, 1290180336, 2, 'miles15cole'),
(3512, 1290180336, 2, 'morton48phillips'),
(3513, 1290180336, 2, 'WebsiteTraffic'),
(3514, 1290180336, 2, 'tammy.hisey2010'),
(3515, 1290180336, 2, 'Ivift1984'),
(3516, 1290180336, 2, 'toby57rowland'),
(3517, 1290180336, 2, 'simon57britt'),
(3518, 1290180336, 2, 'jackie14gray'),
(3519, 1290180336, 2, 'ariel65lindsey'),
(3520, 1290180336, 2, 'victor9patel'),
(3521, 1290180336, 2, 'scottpilgrim2010'),
(3522, 1290180336, 2, 'wilfredo3tillman'),
(3523, 1290180336, 2, 'ci2fit0dub'),
(3524, 1290180336, 2, 'smarthome54'),
(3525, 1290180336, 2, 'jefferson56pruit'),
(3526, 1290180336, 2, 'preston11porter'),
(3527, 1290180336, 2, 'woltchaks911'),
(3528, 1290180336, 2, 'petitesannonces'),
(3529, 1290180336, 2, 'abadon41'),
(3530, 1290180336, 2, 'irwin49best'),
(3531, 1290180336, 2, 'lindenmoenj13'),
(3532, 1290180336, 2, 'korvioceanz'),
(3533, 1290180336, 2, 'okmallorcaer'),
(3534, 1290180336, 2, 'senahalko007'),
(3535, 1290180336, 2, 'carpet_fitter_croydon'),
(3536, 1290180336, 2, 'murray19gamble'),
(3537, 1290180336, 2, 'ass1st'),
(3538, 1290180336, 2, 'kirby93dominguez'),
(3539, 1290180336, 2, 'mondayweb20'),
(3540, 1290180336, 2, 'tinkerme4878'),
(3541, 1290180336, 2, 'kyle2berry'),
(3542, 1290180336, 2, 'WorksgLucien'),
(3543, 1290180336, 2, 'contactscolors'),
(3544, 1290180336, 2, 'gushowe723'),
(3545, 1290180336, 2, 'ernest32mckenzie'),
(3546, 1290180336, 2, 'milesvaughn'),
(3547, 1290180336, 2, 'homer56greer'),
(3548, 1290180336, 2, 'versicherungen'),
(3549, 1290180336, 2, 'a_pennystockprophet'),
(3550, 1290180336, 2, 'kenmathie89'),
(3551, 1290180336, 2, 'guido7a'),
(3552, 1290180336, 2, 'devin17pierce'),
(3553, 1290180336, 2, 'angelinereimer0801'),
(3554, 1290180336, 2, 'caleb19glass'),
(3555, 1290180336, 2, 'wallace92tillman'),
(3556, 1290180336, 2, 'robert8spence'),
(3557, 1290180336, 2, 'garth7goff'),
(3558, 1290180336, 2, 'Marcus190'),
(3559, 1290180336, 2, 'wordpresstheme991'),
(3560, 1290180336, 2, 'rspanish10'),
(3561, 1290180336, 2, 'dementiasymptomsguru'),
(3562, 1290180336, 2, 'cellulite78green'),
(3563, 1290180336, 2, 'irvin93cline'),
(3564, 1290180336, 2, 'xing666'),
(3565, 1290180336, 2, 'marvindishman78'),
(3566, 1290180336, 2, 'superconecs'),
(3567, 1290180336, 2, 'korvcaryw'),
(3568, 1290180336, 2, 'sydney8brown'),
(3569, 1290180336, 2, 'charlie64blanken'),
(3570, 1290180336, 2, 'calvin74langley'),
(3571, 1290180336, 2, 'hiram88cabrera'),
(3572, 1290180336, 2, 'haydel63akau'),
(3573, 1290180336, 2, 'mudassar462'),
(3574, 1290180336, 2, '190'),
(3575, 1290180336, 2, 'atticus'),
(3576, 1290180336, 2, 'du4kit9nite'),
(3577, 1290180336, 2, 'norman1marshall'),
(3578, 1290180336, 2, 'mason7griffin'),
(3579, 1290180336, 2, 'pilotjobs'),
(3580, 1290180336, 2, 'cchase82'),
(3581, 1290180336, 2, 'wm27crawford'),
(3582, 1290180336, 2, 'cheaphotels'),
(3583, 1290180336, 2, 'armando11hull'),
(3584, 1290180336, 2, 'mellanyb16'),
(3585, 1290180336, 2, 'darrylross'),
(3586, 1290180336, 2, 'proform585'),
(3587, 1290180336, 2, 'desktopcomputerpackage'),
(3588, 1290180336, 2, 'wilfredo21tillma'),
(3589, 1290180336, 2, 'PRdisplay'),
(3590, 1290180336, 2, 'harrbell2010'),
(3591, 1290180336, 2, 'chasiscakes'),
(3592, 1290180336, 2, 'conceptinfoinstrument'),
(3593, 1290180336, 2, 'elijah7cervantes'),
(3594, 1290180336, 2, 'ariel49guthrie'),
(3595, 1290180336, 2, 'Joeperry555'),
(3596, 1290180336, 2, 'paul67harrison'),
(3597, 1290180336, 2, 'finance20'),
(3598, 1290180336, 2, 'Airbrushing'),
(3599, 1290180336, 2, 'stoctakingman3203'),
(3600, 1290180336, 2, 'slusher80'),
(3601, 1290180336, 2, 'geoff4mullins'),
(3602, 1290180336, 2, 'al54preston'),
(3603, 1290180336, 2, 'emcrae81'),
(3604, 1290180336, 2, 'p261i9k2'),
(3605, 1290180336, 2, 'HannahGames'),
(3606, 1290180336, 2, 'rensing2010'),
(3607, 1290180336, 2, 'ieltstestonline'),
(3608, 1290180336, 2, 'vincent59ellis'),
(3609, 1290180336, 2, 'parkenmunchen'),
(3610, 1290180336, 2, 'newmarketingera'),
(3611, 1290180336, 2, 'angelaben'),
(3612, 1290180336, 2, 'roboticcleaners'),
(3613, 1290180336, 2, 'dasgood2'),
(3614, 1290180336, 2, 'harrison53wyatt'),
(3615, 1290180336, 2, 'abase12'),
(3616, 1290180336, 2, 'waterkf38'),
(3617, 1290180336, 2, 'johnpeter10020'),
(3618, 1290180336, 2, 'replicawatch'),
(3619, 1290180336, 2, 'natedigby21'),
(3620, 1290180336, 2, 'michaelzadel1'),
(3621, 1290180336, 2, 'manapplew83'),
(3622, 1290180336, 2, 'nukerkds32'),
(3623, 1290180336, 2, 'alma21sebring'),
(3624, 1290180336, 2, 'antithesismbt'),
(3625, 1290180336, 2, 'annej5313'),
(3626, 1290180336, 2, 'globalfj47'),
(3627, 1290180336, 2, 'kermitfarley41'),
(3628, 1290180336, 2, 'jerseyhe'),
(3629, 1290180336, 2, 'devin4sampson'),
(3630, 1290180336, 2, 'remediesperimenopause'),
(3631, 1290180336, 2, 'brought'),
(3632, 1290180336, 2, 'tamslaught'),
(3633, 1290180336, 2, 'searchmaker8'),
(3634, 1290180336, 2, 'patrick48h3yes'),
(3635, 1290180336, 2, 'nonstopicon17'),
(3636, 1290180336, 2, 'nharvey82'),
(3637, 1290180336, 2, 'weightliftel'),
(3638, 1290180336, 2, 'jerome74431'),
(3639, 1290180336, 2, 'hugo99koch'),
(3640, 1290180336, 2, 'caraccidentclaims'),
(3641, 1290180336, 2, 'FrancyBella76'),
(3642, 1290180336, 2, 'cambridgepeak'),
(3643, 1290180336, 2, 'cxush37777'),
(3644, 1290180336, 2, 'stubborn02'),
(3645, 1290180336, 2, 'knchilders'),
(3646, 1290180336, 2, 'zojirushibread3'),
(3647, 1290180336, 2, 'charisma89white'),
(3648, 1290180336, 2, 'employmentlaw0'),
(3649, 1290180336, 2, 'earnest82osborn'),
(3650, 1290180336, 2, 'esteban12mcneil'),
(3651, 1290180336, 2, 'gerardo39burton'),
(3652, 1290180336, 2, 'esteban12mcneil'),
(3653, 1290180336, 2, 'eliseo28abbott'),
(3654, 1290180336, 2, 'timmy18cox'),
(3655, 1290180336, 2, 'elisfeo13phillips'),
(3656, 1290180336, 2, 'saul23silva'),
(3657, 1290180336, 2, 'loyd11chase'),
(3658, 1290180336, 2, 'penisenlargeme988'),
(3659, 1290180336, 2, 'qjuliahendricksp'),
(3660, 1290180336, 2, 'JamesWM1237'),
(3661, 1290180336, 2, 'RaileyShenkkat00'),
(3662, 1290180336, 2, 'jimsdetox'),
(3663, 1290180336, 2, 'vietnamvisanow'),
(3664, 1290180336, 2, 'rachialnics'),
(3665, 1290180336, 2, 'Freeman21E'),
(3666, 1290180336, 2, 'webhostingbest'),
(3667, 1290180336, 2, 'photovoltaikmodul'),
(3668, 1290180336, 2, 'yanti5q6yuliani'),
(3669, 1290180336, 2, 'rainlun'),
(3670, 1290180336, 2, 'CartoonGames'),
(3671, 1290180336, 2, 'rahul'),
(3672, 1290180336, 2, 'francis4bradford'),
(3673, 1290180336, 2, 'jleonardo'),
(3674, 1290180336, 2, 'lea'),
(3675, 1290180336, 2, 'v8turdrive'),
(3676, 1290180336, 2, 'Michal478'),
(3677, 1290180336, 2, 'theinfo3products'),
(3678, 1290180336, 2, 'ai4danger8dub'),
(3679, 1290180336, 2, 'marco6crawford'),
(3680, 1290180336, 2, 'micah5shields'),
(3681, 1290180336, 2, 'Forex_Scalping_Girl'),
(3682, 1290180336, 2, 'perryreyes14'),
(3683, 1290180336, 2, 'alfredo58briggs'),
(3684, 1290180336, 2, 'vekelectric'),
(3685, 1290180336, 2, 'seanhuff1'),
(3686, 1290180336, 2, 'cleveland17garci'),
(3687, 1290180336, 2, 'reuben5eaton'),
(3688, 1290180336, 2, 'sylvester8berry'),
(3689, 1290180336, 2, 'raul67henson'),
(3690, 1290180336, 2, 'on743playgame'),
(3691, 1290180336, 2, 'kellyroan78'),
(3692, 1290180336, 2, 'marivicwales34'),
(3693, 1290180336, 2, 'aaron33glover'),
(3694, 1290180336, 2, 'tommie14jensen'),
(3695, 1290180336, 2, 'verocigarettes'),
(3696, 1290180336, 2, 'gavelmasonjonath'),
(3697, 1290180336, 2, 'hollis7castillo'),
(3698, 1290180336, 2, 'Aldengo168'),
(3699, 1290180336, 2, 'veronicanelsen'),
(3700, 1290180336, 2, 'fixprematureejaculation'),
(3701, 1290180336, 2, 'gerald43chaney'),
(3702, 1290180336, 2, 'haircareproducts'),
(3703, 1290180336, 2, 'Omari78'),
(3704, 1290180336, 2, 'nicodelatado06'),
(3705, 1290180336, 2, 'otis46randolph'),
(3706, 1290180336, 2, 'reed71hicks'),
(3707, 1290180336, 2, 'eryn88malena'),
(3708, 1290180336, 2, 'anunna1ki'),
(3709, 1290180336, 2, 'britgames22'),
(3710, 1290180336, 2, 'londongirl2012'),
(3711, 1290180336, 2, 'joelagame32'),
(3712, 1290180336, 2, 'aboutflowerfact'),
(3713, 1290180336, 2, 'jayson1buchanan489'),
(3714, 1290180336, 2, 'tawnyhar24'),
(3715, 1290180336, 2, 'work_from_home'),
(3716, 1290180336, 2, 'BestSupplements'),
(3717, 1290180336, 2, 'josealke77'),
(3718, 1290180336, 2, 'korvixru2'),
(3719, 1290180336, 2, 'micheal7bond'),
(3720, 1290180336, 2, 'miles15sosa'),
(3721, 1290180336, 2, 'omoole'),
(3722, 1290180336, 2, 'korvixpeak7'),
(3723, 1290180336, 2, 'anderson75santia'),
(3724, 1290180336, 2, 'texasholdem07'),
(3725, 1290180336, 2, 'tracystokely78'),
(3726, 1290180336, 2, 'korvprofz1'),
(3727, 1290180336, 2, 'korvixru1'),
(3728, 1290180336, 2, 'strippersinphilly'),
(3729, 1290180336, 2, 'ragnarasplund54'),
(3730, 1290180336, 2, 'marioregistryclean'),
(3731, 1290180336, 2, 'don2hancock'),
(3732, 1290180336, 2, 'tinnitus9558'),
(3733, 1290180336, 2, 'lipi07'),
(3734, 1290180336, 2, 'polykristallin'),
(3735, 1290180336, 2, 'damac012'),
(3736, 1290180336, 2, 'helenjones666'),
(3737, 1290180336, 2, 'indianapolishome'),
(3738, 1290180336, 2, 'peterlord8'),
(3739, 1290180336, 2, 'Harve571'),
(3740, 1290180336, 2, 'gerald57ryan'),
(3741, 1290180336, 2, 'airsoft108'),
(3742, 1290180336, 2, 'johnsoncityjobsnet'),
(3743, 1290180336, 2, 'phillip51schwart'),
(3744, 1290180336, 2, 'nickybd2'),
(3745, 1290180336, 2, 'jean21gibson'),
(3746, 1290180336, 2, 'harlan1flowers'),
(3747, 1290180336, 2, 'jdawg2834'),
(3748, 1290180336, 2, 'Dyerc3T'),
(3749, 1290180336, 2, 'devans82'),
(3750, 1290180336, 2, 'jenn1supersonic'),
(3751, 1290180336, 2, 'cedric82'),
(3752, 1290180336, 2, 'amos67best'),
(3753, 1290180336, 2, 'rwright87'),
(3754, 1290180336, 2, 'marketinggold69internet'),
(3755, 1290180336, 2, 'ernesthoang'),
(3756, 1290180336, 2, 'Phen'),
(3757, 1290180336, 2, 'Phen'),
(3758, 1290180336, 2, 'sydney77frye'),
(3759, 1290180336, 2, 'antoine56delgado'),
(3760, 1290180336, 2, 'bospeaker01'),
(3761, 1290180336, 2, 'rigoberto375hurst'),
(3762, 1290180336, 2, 'provillus553'),
(3763, 1290180336, 2, 'ecommercehost'),
(3764, 1290180336, 2, 'pemm2xayeap'),
(3765, 1290180336, 2, 'iinfotech10'),
(3766, 1290180336, 2, 'rocco31mann'),
(3767, 1290180336, 2, 'Greylip45'),
(3768, 1290180336, 2, 'fullcontactjim'),
(3769, 1290180336, 2, 'santanu007'),
(3770, 1290180336, 2, 'sonnenenergie'),
(3771, 1290180336, 2, 'sheriblake46'),
(3772, 1290180336, 2, 'martinzblackz'),
(3773, 1290180336, 2, 'duncan92workman'),
(3774, 1290180336, 2, 'ruggedbenniwe123'),
(3775, 1290180336, 2, 'iceiceyy22'),
(3776, 1290180336, 2, 'quintadolago'),
(3777, 1290180336, 2, 'quintadolago'),
(3778, 1290180336, 2, 'lyyzh78'),
(3779, 1290180336, 2, 'stepolin'),
(3780, 1290180336, 2, 'robcquezada'),
(3781, 1290180336, 2, 'Rosie11'),
(3782, 1290180336, 2, 'normnabaro22'),
(3783, 1290180336, 2, 'Kawig89'),
(3784, 1290180336, 2, 'guitar2474u'),
(3785, 1290180336, 2, 'alan2skinner'),
(3786, 1290180336, 2, 'rhensley82'),
(3787, 1290180336, 2, 'davidthorne78'),
(3788, 1290180336, 2, 'shirleywishart83'),
(3789, 1290180336, 2, 'kpaulk81'),
(3790, 1290180336, 2, 'joobkae17'),
(3791, 1290180336, 2, 'jackie3peterson'),
(3792, 1290180336, 2, 'ty84gillespie'),
(3793, 1290180336, 2, 'GertrudeGaanee21'),
(3794, 1290180336, 2, 'etftradestrend0'),
(3795, 1290180336, 2, 'ashley54goodwin'),
(3796, 1290180336, 2, 'freegamess'),
(3797, 1290180336, 2, 'pretendcityorg11'),
(3798, 1290180336, 2, 'clyde9hess'),
(3799, 1290180336, 2, 'joobkae16'),
(3800, 1290180336, 2, 'davidnager1'),
(3801, 1290180336, 2, 'rodrickrodriguny'),
(3802, 1290180336, 2, 'tom9camacho'),
(3803, 1290180336, 2, 'terrencendodsonu'),
(3804, 1290180336, 2, 'boersenbriefe8'),
(3805, 1290180336, 2, 'irwan7q5hermawan'),
(3806, 1290180336, 2, 'petez58boyd'),
(3807, 1290180336, 2, 'garry58morales'),
(3808, 1290180336, 2, 'nanmakin1'),
(3809, 1290180336, 2, 'seo2linkman'),
(3810, 1290180336, 2, 'roosevelt76blank'),
(3811, 1290180336, 2, 'joobkae15'),
(3812, 1290180336, 2, 'russel89warner'),
(3813, 1290180336, 2, 'reid91snyder'),
(3814, 1290180336, 2, 'naturaltreatment6'),
(3815, 1290180336, 2, 'hugo3629'),
(3816, 1290180336, 2, 'joobkae14'),
(3817, 1290180336, 2, 'larry65padilla'),
(3818, 1290180336, 2, 'runnermonitors055'),
(3819, 1290180336, 2, 'list-of-50'),
(3820, 1290180336, 2, 'dondoregeyq'),
(3821, 1290180336, 2, 'neelth88'),
(3822, 1290180336, 2, 'musomax01'),
(3823, 1290180336, 2, 'johnpitt'),
(3824, 1290180336, 2, 'Khalidah1'),
(3825, 1290180336, 2, 'Ludlows'),
(3826, 1290180336, 2, 'adlfhtlra'),
(3827, 1290180336, 2, 'Trentonattorney11'),
(3828, 1290180336, 2, 'Khalidah1'),
(3829, 1290180336, 2, 'emilywhite777'),
(3830, 1290180336, 2, 'curtin54medieval'),
(3831, 1290180336, 2, 'margarito1mejia'),
(3832, 1290180336, 2, 'jamal37lopez'),
(3833, 1290180336, 2, 'AnnaLorexa'),
(3834, 1290180336, 2, 'aswer8'),
(3835, 1290180336, 2, 'anyloans'),
(3836, 1290180336, 2, 'gerry46whitney'),
(3837, 1290180336, 2, 'steve11korb'),
(3838, 1290180336, 2, 'Hairstyle101'),
(3839, 1290180336, 2, 'mario2fischer'),
(3840, 1290180336, 2, 'son17harvey'),
(3841, 1290180336, 2, 'shelton7mills'),
(3842, 1290180336, 2, 'will6pierce'),
(3843, 1290180336, 2, 'barndesign11'),
(3844, 1290180336, 2, 'everettshorty2010'),
(3845, 1290180336, 2, 'diannasmith'),
(3846, 1290180336, 2, 'donnell4bray'),
(3847, 1290180336, 2, 'ajames82'),
(3848, 1290180336, 2, 'clay7hanson'),
(3849, 1290180336, 2, 'memoryfoam24'),
(3850, 1290180336, 2, 'rafael16guerra'),
(3851, 1290180336, 2, 'the_carpet_fitter'),
(3852, 1290180336, 2, 'trace828mcm'),
(3853, 1290180336, 2, 'Chrolor354'),
(3854, 1290180336, 2, 'caleb9decker'),
(3855, 1290180336, 2, 'sammy2price'),
(3856, 1290180336, 2, 'searsfreebetting'),
(3857, 1290180336, 2, 'timmy1011'),
(3858, 1290180336, 2, 'luxuryhotelskotakinabalu'),
(3859, 1290180336, 2, 'joobkae13'),
(3860, 1290180336, 2, 'hangingtoughfool1'),
(3861, 1290180336, 2, 'michaelgoldstone'),
(3862, 1290180336, 2, 'valentin6kidd'),
(3863, 1290180336, 2, 'singleboardgod'),
(3864, 1290180336, 2, 'noel9dale'),
(3865, 1290180336, 2, 'shane5walker'),
(3866, 1290180336, 2, 'altonfitz2419'),
(3867, 1290180336, 2, 'AnxiousJoe'),
(3868, 1290180336, 2, 'registrykit'),
(3869, 1290180336, 2, 'damien7ingram'),
(3870, 1290180336, 2, 'Hudson2'),
(3871, 1290180336, 2, 'polycrystalline'),
(3872, 1290180336, 2, 'colin45mckenzie'),
(3873, 1290180336, 2, 'emailmarketingservices'),
(3874, 1290180336, 2, 'datingadvisers'),
(3875, 1290180336, 2, 'vinent5morro'),
(3876, 1290180336, 2, 'xiaobao'),
(3877, 1290180336, 2, 'pedro75cal'),
(3878, 1290180336, 2, 'splicer88'),
(3879, 1290180336, 2, 'watchfulfable76'),
(3880, 1290180336, 2, 'morris8hicks'),
(3881, 1290180336, 2, 'Carhirenew123'),
(3882, 1290180336, 2, 'clint19davis'),
(3883, 1290180336, 2, 'breezyavailable'),
(3884, 1290180336, 2, 'rizwantahir1'),
(3885, 1290180336, 2, 'brwhitley78'),
(3886, 1290180336, 2, 'wallacekgibson'),
(3887, 1290180336, 2, 'wilburdillon624'),
(3888, 1290180336, 2, 'chinaflightcases'),
(3889, 1290180336, 2, 'dncastellone'),
(3890, 1290180336, 2, 'willis78harrison'),
(3891, 1290180336, 2, 'peterforsyth78'),
(3892, 1290180336, 2, 'EsperMax'),
(3893, 1290180336, 2, 'fushigiball178'),
(3894, 1290180336, 2, 'marcelino1johns'),
(3895, 1290180336, 2, 'neopetseopoints1'),
(3896, 1290180336, 2, 'unlock55iphone4'),
(3897, 1290180336, 2, 'daniel72morrison'),
(3898, 1290180336, 2, 'pratiksangle2'),
(3899, 1290180336, 2, 'growtaller'),
(3900, 1290180336, 2, 'abe6thomas'),
(3901, 1290180336, 2, 'samuel74morton'),
(3902, 1290180336, 2, 'alton79turner'),
(3903, 1290180336, 2, 'stevendodson'),
(3904, 1290180336, 2, 'kendall8porter'),
(3905, 1290180336, 2, 'gavin4clarke'),
(3906, 1290180336, 2, 'carrymill'),
(3907, 1290180336, 2, 'robby7anthony'),
(3908, 1290180336, 2, 'jeric007'),
(3909, 1290180336, 2, 'reebokjersey'),
(3910, 1290180336, 2, 'smithgordon'),
(3911, 1290180336, 2, 'carloss'),
(3912, 1290180336, 2, 'zelleffizienz'),
(3913, 1290180336, 2, 'grammowitch'),
(3914, 1290180336, 2, 'brperry88'),
(3915, 1290180336, 2, 'gnemeno'),
(3916, 1290180336, 2, 'xavier91oneil'),
(3917, 1290180336, 2, 'williams5buckley'),
(3918, 1290180336, 2, 'InDemandPlumbing'),
(3919, 1290180336, 2, 'designer86hodges'),
(3920, 1290180336, 2, 'tracy41aguilar'),
(3921, 1290180336, 2, 'sandyland123'),
(3922, 1290180336, 2, 'rstagpartyideas2r'),
(3923, 1290180336, 2, 'bbgadget111'),
(3924, 1290180336, 2, 'pratiksangle'),
(3925, 1290180336, 2, 'angelstone788'),
(3926, 1290180336, 2, 'jstraw85'),
(3927, 1290180336, 2, 'chairsforbaby628'),
(3928, 1290180336, 2, 'carter37frye'),
(3929, 1290180336, 2, 'antoine68harring'),
(3930, 1290180336, 2, 'nancycohen555'),
(3931, 1290180336, 2, 'carmelo37sears'),
(3932, 1290180336, 2, 'johnnybgood1975'),
(3933, 1290180336, 2, 'VacuumC'),
(3934, 1290180336, 2, 'wallacekgibson'),
(3935, 1290180336, 2, 'johnromanshade90'),
(3936, 1290180336, 2, 'sytycdt1'),
(3937, 1290180336, 2, 'lucas4vincent'),
(3938, 1290180336, 2, 'dreams21'),
(3939, 1290180336, 2, 'salvatore7parks'),
(3940, 1290180336, 2, 'dgodwin80'),
(3941, 1290180336, 2, 'robbie9walsh'),
(3942, 1290180336, 2, 'regkd383'),
(3943, 1290180336, 2, 'russel42gardner'),
(3944, 1290180336, 2, 'elegette82'),
(3945, 1290180336, 2, 'jeffrey6guzman'),
(3946, 1290180336, 2, 'wyatt58travis'),
(3947, 1290180336, 2, 'johnie9gentry'),
(3948, 1290180336, 2, 'clearngdu337'),
(3949, 1290180336, 2, 'SimonYardleyz'),
(3950, 1290180336, 2, 'jessicamc023'),
(3951, 1290180336, 2, 'alexis21barron'),
(3952, 1290180336, 2, 'everywherembt'),
(3953, 1290180336, 2, 'bootlegmovies305'),
(3954, 1290180336, 2, 'praprisri4466'),
(3955, 1290180336, 2, 'felipe65howe'),
(3956, 1290180336, 2, 'randal3jensen'),
(3957, 1290180336, 2, 'Roscoe2'),
(3958, 1290180336, 2, 'Reeberto65'),
(3959, 1290180336, 2, 'monte3hull'),
(3960, 1290180336, 2, 'dacrime'),
(3961, 1290180336, 2, 'tommy2tone'),
(3962, 1290180336, 2, 'jeremy12boone'),
(3963, 1290180336, 2, 'woodrow65waller'),
(3964, 1290180336, 2, 'micheal4manning'),
(3965, 1290180336, 2, 'melvin29molina'),
(3966, 1290180336, 2, 'jacob83mcleod'),
(3967, 1290180336, 2, 'debradixon444'),
(3968, 1290180336, 2, 'warrantsmcglade'),
(3969, 1290180336, 2, 'nfontana22'),
(3970, 1290180336, 2, 'cruz87buck'),
(3971, 1290180336, 2, 'samudilwor23'),
(3972, 1290180336, 2, 'Fatburner79'),
(3973, 1290180336, 2, 'kerry17lyons'),
(3974, 1290180336, 2, 'jasoncats393'),
(3975, 1290180336, 2, 'dino48clarke'),
(3976, 1290180336, 2, 'jake71coleman'),
(3977, 1290180336, 2, 'cooingeyesight2'),
(3978, 1290180336, 2, 'timsusan'),
(3979, 1290180336, 2, 'simon6lewis'),
(3980, 1290180336, 2, 'xavierburns80'),
(3981, 1290180336, 2, 'denny1potts'),
(3982, 1290180336, 2, 'viewuser5'),
(3983, 1290180336, 2, 'hal21blackburn'),
(3984, 1290180336, 2, 'musethebest'),
(3985, 1290180336, 2, 'basil77howe'),
(3986, 1290180336, 2, 'tomas8serrano'),
(3987, 1290180336, 2, 'dragonfigurineman'),
(3988, 1290180336, 2, 'lavern5hoover'),
(3989, 1290180336, 2, 'w3ndlovu'),
(3990, 1290180336, 2, 'richard38blake'),
(3991, 1290180336, 2, 'leon88whitehead'),
(3992, 1290180336, 2, 'boltoncyril999'),
(3993, 1290180336, 2, 'deinneustieout'),
(3994, 1290180336, 2, 'cheap54mattress7'),
(3995, 1290180336, 2, 'coffeemakers345'),
(3996, 1290180336, 2, 'aquarium4books'),
(3997, 1290180336, 2, 'NikkiP'),
(3998, 1290180336, 2, 'dollar38ke'),
(3999, 1290180336, 2, 'saxonlogins'),
(4000, 1290180336, 2, 'jamesrose'),
(4001, 1290180336, 2, 'Prior32'),
(4002, 1290180336, 2, 'lonnirewe8lloyd32'),
(4003, 1290180336, 2, 'Kennperk'),
(4004, 1290180336, 2, 'rish12u'),
(4005, 1290180336, 2, 'edter1122'),
(4006, 1290180336, 2, 'gamesbini33'),
(4007, 1290180336, 2, 'branden28donovan'),
(4008, 1290180336, 2, 'pablo12morris'),
(4009, 1290180336, 2, 'tyson76knight'),
(4010, 1290180336, 2, 'noah3wilkins'),
(4011, 1290180336, 2, 'AngelsandDemons'),
(4012, 1290180336, 2, 'irvin87morgan'),
(4013, 1290180336, 2, 'sesamedentist'),
(4014, 1290180336, 2, 'agrappa82'),
(4015, 1290180336, 2, 'glowery81'),
(4016, 1290180336, 2, 'libaishan20'),
(4017, 1290180336, 2, 'CaitlandCait'),
(4018, 1290180336, 2, 'lynnalberts'),
(4019, 1290180336, 2, 'vincent68morrow'),
(4020, 1290180336, 2, 'tony9morgan'),
(4021, 1290180336, 2, 'quentin95camacho'),
(4022, 1290180336, 2, 'clark31hart'),
(4023, 1290180336, 2, 'elvis97gamble'),
(4024, 1290180336, 2, 'percy9oliver'),
(4025, 1290180336, 2, 'jpmortgageme'),
(4026, 1290180336, 2, 'nathan10'),
(4027, 1290180336, 2, 'Jayicay74'),
(4028, 1290180336, 2, 'amos8cherry'),
(4029, 1290180336, 2, 'dwight9jenkins'),
(4030, 1290180336, 2, 'RogerMason'),
(4031, 1290180336, 2, 'felix79'),
(4032, 1290180336, 2, 'emory816odom'),
(4033, 1290180336, 2, 'nhancock90210'),
(4034, 1290180336, 2, 'laverne8macias'),
(4035, 1290180336, 2, 'heriberto87samps'),
(4036, 1290180336, 2, 'feewin6463n'),
(4037, 1290180336, 2, 'ahmad97wallace'),
(4038, 1290180336, 2, 'watimena1m2sangra'),
(4039, 1290180336, 2, 'boycows27'),
(4040, 1290180336, 2, 'barry41wiggins'),
(4041, 1290180336, 2, 'learningcollege1924'),
(4042, 1290180336, 2, 'Durriyah4'),
(4043, 1290180336, 2, 'Warner22'),
(4044, 1290180336, 2, 'edmund76stone'),
(4045, 1290180336, 2, 'mike27schultz'),
(4046, 1290180336, 2, 'alvinawat'),
(4047, 1290180336, 2, 'aeron20100'),
(4048, 1290180336, 2, 'niffjoy'),
(4049, 1290180336, 2, 'Missyqwart'),
(4050, 1290180336, 2, 'george3i93'),
(4051, 1290180336, 2, 'antwan49mitchell'),
(4052, 1290180336, 2, 'kellyasert26'),
(4053, 1290180336, 2, 'carstens'),
(4054, 1290180336, 2, 'rich55conner'),
(4055, 1290180336, 2, 'yamraj0101'),
(4056, 1290180336, 2, 'lemuel58crane'),
(4057, 1290180336, 2, 'posefauxongles'),
(4058, 1290180336, 2, 'Milius25'),
(4059, 1290180336, 2, 'citizenlaw037'),
(4060, 1290180336, 2, 'veloso219'),
(4061, 1290180336, 2, 'darnell1vega'),
(4062, 1290180336, 2, 'clark21mcintosh'),
(4063, 1290180336, 2, 'courtney13curtis'),
(4064, 1290180336, 2, 'chenlugang'),
(4065, 1290180336, 2, 'sencharp'),
(4066, 1290180336, 2, 'raymond38388'),
(4067, 1290180336, 2, 'cruz38hurley'),
(4068, 1290180336, 2, 'Syberg01'),
(4069, 1290180336, 2, 'williams39ericks'),
(4070, 1290180336, 2, 'marc67pruitt'),
(4071, 1290180336, 2, 'verasteele205'),
(4072, 1290180336, 2, 'finnigan27stance'),
(4073, 1290180336, 2, 'kirk15cross'),
(4074, 1290180336, 2, 'Zafirah187'),
(4075, 1290180336, 2, 'ksresort01'),
(4076, 1290180336, 2, 'yeildinvest87'),
(4077, 1290180336, 2, 'hamptonparts'),
(4078, 1290180336, 2, 'drummond01'),
(4079, 1290180336, 2, 'colocatedhosting'),
(4080, 1290180336, 2, 'donald7leaf'),
(4081, 1290180336, 2, 'oliverle34'),
(4082, 1290180336, 2, 'solarstrom'),
(4083, 1290180336, 2, 'otto25rodriquez'),
(4084, 1290180336, 2, 'cartoon93ke'),
(4085, 1290180336, 2, 'kumara'),
(4086, 1290180336, 2, 'kareem7harris'),
(4087, 1290180336, 2, 'noraross212'),
(4088, 1290180336, 2, 'timonabou23'),
(4089, 1290180336, 2, 'l.chaos45'),
(4090, 1290180336, 2, 'haris5v5mandala'),
(4091, 1290180336, 2, 'carey87booth'),
(4092, 1290180336, 2, 'savvyspice21'),
(4093, 1290180336, 2, 'andres55smith'),
(4094, 1290180336, 2, 'Daniellelloyd'),
(4095, 1290180336, 2, 'Thinggynoly'),
(4096, 1290180336, 2, 'forest4torenso'),
(4097, 1290180336, 2, 'milesvaughn99'),
(4098, 1290180336, 2, 'drake2howard'),
(4099, 1290180336, 2, 'ferren7menowae'),
(4100, 1290180336, 2, 'joobkae12'),
(4101, 1290180336, 2, 'wordyembedchap'),
(4102, 1290180336, 2, 'suzansmith01'),
(4103, 1290180336, 2, 'sbaird83'),
(4104, 1290180336, 2, 'bennie42reyes'),
(4105, 1290180336, 2, 'thekawasakiboy'),
(4106, 1290180336, 2, 'wonghing158'),
(4107, 1290180336, 2, 'yashhonda'),
(4108, 1290180336, 2, 'mebekarar1'),
(4109, 1290180336, 2, 'gleamingmosaic8'),
(4110, 1290180336, 2, 'cheatsjamal5'),
(4111, 1290180336, 2, 'grow4weed'),
(4112, 1290180336, 2, 'howiej77'),
(4113, 1290180336, 2, 'dustin3morton'),
(4114, 1290180336, 2, 'rigoberto52guerr'),
(4115, 1290180336, 2, 'BrettG344'),
(4116, 1290180336, 2, 'firmwork01'),
(4117, 1290180336, 2, 'Diton398'),
(4118, 1290180336, 2, 'sayed85'),
(4119, 1290180336, 2, 'emmett7shelton'),
(4120, 1290180336, 2, 'hensondeano'),
(4121, 1290180336, 2, 'beth52wright'),
(4122, 1290180336, 2, 'gastmaal6j'),
(4123, 1290180336, 2, 'herzogatrel'),
(4124, 1290180336, 2, 'monte64tate'),
(4125, 1290180336, 2, 'bobi4u4budiman'),
(4126, 1290180336, 2, 'shawn3randolph'),
(4127, 1290180336, 2, 'kenneth1gibbsoo9'),
(4128, 1290180336, 2, 'demetrius9bray'),
(4129, 1290180336, 2, 'millytill0'),
(4130, 1290180336, 2, 'mgreer83'),
(4131, 1290180336, 2, 'ukvideoproduction'),
(4132, 1290180336, 2, 'terrywahila'),
(4133, 1290180336, 2, 'slappydummy2933'),
(4134, 1290180336, 2, 'seemon'),
(4135, 1290180336, 2, 'goldenmarashicom'),
(4136, 1290180336, 2, 'frman250fore'),
(4137, 1290180336, 2, 'andre3orr'),
(4138, 1290180336, 2, 'gyhy12qa'),
(4139, 1290180336, 2, 'dougnadel23'),
(4140, 1290180336, 2, 'HowtomixHCG'),
(4141, 1290180336, 2, 'jules29beasley'),
(4142, 1290180336, 2, 'jetstar21'),
(4143, 1290180336, 2, 'laurence42parks'),
(4144, 1290180336, 2, 'annhyde555'),
(4145, 1290180336, 2, 'christmasdecoration'),
(4146, 1290180336, 2, 'covercreator8'),
(4147, 1290180336, 2, 'benjamin83massey'),
(4148, 1290180336, 2, 'sankofa'),
(4149, 1290180336, 2, 'robertbocan28'),
(4150, 1290180336, 2, 'seymour65doyle'),
(4151, 1290180336, 2, 'adapypeSnonna'),
(4152, 1290180336, 2, 'emipiexassist'),
(4153, 1290180336, 2, 'AcouckAdjounk'),
(4154, 1290180336, 2, 'wordpressmaker3'),
(4155, 1290180336, 2, 'henriburgo24'),
(4156, 1290180336, 2, 'Philipjamws8'),
(4157, 1290180336, 2, 'ervin46delacruz'),
(4158, 1290180336, 2, 'delmar11holden'),
(4159, 1290180336, 2, 'proteinneed99'),
(4160, 1290180336, 2, 'matt4gonzales'),
(4161, 1290180336, 2, 'murray1dennis'),
(4162, 1290180336, 2, 'alex53'),
(4163, 1290180336, 2, 'josue45potter'),
(4164, 1290180336, 2, 'numbers54carpent'),
(4165, 1290180336, 2, 'george55medieval'),
(4166, 1290180336, 2, 'jljoeylyn67'),
(4167, 1290180336, 2, 'adam6albert'),
(4168, 1290180336, 2, 'jamel6morris'),
(4169, 1290180336, 2, 'wf123456'),
(4170, 1290180336, 2, 'marhicks77'),
(4171, 1290180336, 2, 'seomaster4u'),
(4172, 1290180336, 2, 'otis79barnes'),
(4173, 1290180336, 2, 'DialupLicker'),
(4174, 1290180336, 2, 'rodrick91hess'),
(4175, 1290180336, 2, 'burton2glover'),
(4176, 1290180336, 2, 'musclewarfarereview'),
(4177, 1290180336, 2, 'FileHostingMaker'),
(4178, 1290180336, 2, 'promostore'),
(4179, 1290180336, 2, 'robin93beasley'),
(4180, 1290180336, 2, 'uptightfeud20'),
(4181, 1290180336, 2, 'alexisfisher'),
(4182, 1290180336, 2, 'ivorykmccray'),
(4183, 1290180336, 2, 'dentistleo47banks'),
(4184, 1290180336, 2, 'everett32velasqu'),
(4185, 1290180336, 2, 'alva64kaufman'),
(4186, 1290180336, 2, 'cliff28perez'),
(4187, 1290180336, 2, 'frozencrabclaws345'),
(4188, 1290180336, 2, 'scotty7wheeler'),
(4189, 1290180336, 2, 'meccabingo243'),
(4190, 1290180336, 2, 'frank38smite'),
(4191, 1290180336, 2, 'edmund26stone'),
(4192, 1290180336, 2, 'donnell32peterso'),
(4193, 1290180336, 2, 'zobOccawaycaG'),
(4194, 1290180336, 2, 'gentraff121'),
(4195, 1290180336, 2, 'linda554'),
(4196, 1290180336, 2, 'Danielle'),
(4197, 1290180336, 2, 'boyd7curtis'),
(4198, 1290180336, 2, 'halogens'),
(4199, 1290180336, 2, 'jason9wolf'),
(4200, 1290180336, 2, 'jorge57adkins'),
(4201, 1290180336, 2, 'wardsupplee88'),
(4202, 1290180336, 2, 'rcen79user'),
(4203, 1290180336, 2, 'instantsocial77'),
(4204, 1290180336, 2, 'Atran366'),
(4205, 1290180336, 2, 'milton4mcbride'),
(4206, 1290180336, 2, 'johnmichaelwilliams'),
(4207, 1290180336, 2, 'Codyjurado'),
(4208, 1290180336, 2, 'spamerusinfo'),
(4209, 1290180336, 2, 'firathaber'),
(4210, 1290180336, 2, 'eew92mik'),
(4211, 1290180336, 2, 'yuda7y2pradana'),
(4212, 1290180336, 2, 'monocrystalline'),
(4213, 1290180336, 2, 'johnweelson'),
(4214, 1290180336, 2, 'killfinsmiltesn'),
(4215, 1290180336, 2, 'lawyer6'),
(4216, 1290180336, 2, 'hotellion71'),
(4217, 1290180336, 2, 'ramiro3joyner'),
(4218, 1290180336, 2, 'earlsun2ylorr'),
(4219, 1290180336, 2, 'earlsun2ylorr'),
(4220, 1290180336, 2, 'deptcollection13'),
(4221, 1290180336, 2, 'adam22'),
(4222, 1290180336, 2, 'playstation2010'),
(4223, 1290180336, 2, 'ron7ayala'),
(4224, 1290180336, 2, 'Kantuej43'),
(4225, 1290180336, 2, 'michael36woodwar'),
(4226, 1290180336, 2, 'faser22'),
(4227, 1290180336, 2, 'francistr23'),
(4228, 1290180336, 2, 'penghan'),
(4229, 1290180336, 2, 'lewis7patton'),
(4230, 1290180336, 2, 'ewis7patton'),
(4231, 1290180336, 2, 'richamiller25'),
(4232, 1290180336, 2, 'nithin3blasberg'),
(4233, 1290180336, 2, 'GallantBMan'),
(4234, 1290180336, 2, 'UtithNene'),
(4235, 1290180336, 2, 'dietgirl33'),
(4236, 1290180336, 2, 'acnenomore946'),
(4237, 1290180336, 2, 'jl016740'),
(4238, 1290180336, 2, 'margele383'),
(4239, 1290180336, 2, 'photovoltaicmodule'),
(4240, 1290180336, 2, 'fairlri383'),
(4241, 1290180336, 2, 'christian25'),
(4242, 1290180336, 2, 'gaillovesallen'),
(4243, 1290180336, 2, 'jose7greer'),
(4244, 1290180336, 2, 'wood92aaron'),
(4245, 1290180336, 2, 'wilburn39phelps'),
(4246, 1290180336, 2, 'marco112crawford'),
(4247, 1290180336, 2, 'Japcy07'),
(4248, 1290180336, 2, 'calypsoclothing5'),
(4249, 1290180336, 2, 'vaska94'),
(4250, 1290180336, 2, 'nealfordhealth'),
(4251, 1290180336, 2, 'fapturbo83x'),
(4252, 1290180336, 2, 'trenton7mullen'),
(4253, 1290180336, 2, 'ensuemo'),
(4254, 1290180336, 2, 'askyourbitch'),
(4255, 1290180336, 2, 'reginaldgill'),
(4256, 1290180336, 2, 'disneyguide17'),
(4257, 1290180336, 2, 'harlan4wright'),
(4258, 1290180336, 2, 'yamraj0101'),
(4259, 1290180336, 2, 'calvin736mosley'),
(4260, 1290180336, 2, 'allinclusivevacation'),
(4261, 1290180336, 2, 'jordan93leach'),
(4262, 1290180336, 2, 'luther2mckenzie'),
(4263, 1290180336, 2, 'MarBorDraiz'),
(4264, 1290180336, 2, 'WellItWorks'),
(4265, 1290180336, 2, 'robmrpennington'),
(4266, 1290180336, 2, 'martinsmile01'),
(4267, 1290180336, 2, 'silas35wilkins'),
(4268, 1290180336, 2, 'RColleen256'),
(4269, 1290180336, 2, 'chase73crosby'),
(4270, 1290180336, 2, 'classifiedinvests330'),
(4271, 1290180336, 2, 'oscar63contreras'),
(4272, 1290180336, 2, 'wiley4b'),
(4273, 1290180336, 2, 'kellybeany'),
(4274, 1290180336, 2, 'sushma12'),
(4275, 1290180336, 2, 'MarBorDraiz'),
(4276, 1290180336, 2, 'carter52carlson'),
(4277, 1290180336, 2, 'felter907'),
(4278, 1290180336, 2, 'Ersguterjunge'),
(4279, 1290180336, 2, 'willard579vinson'),
(4280, 1290180336, 2, 'gabejge49'),
(4281, 1290180336, 2, 'barton4adams'),
(4282, 1290180336, 2, 'petershipers'),
(4283, 1290180336, 2, 'david1512'),
(4284, 1290180336, 2, 'Effitiledge'),
(4285, 1290180336, 2, 'Feminomikeymn'),
(4286, 1290180336, 2, 'trackcellphone888'),
(4287, 1290180336, 2, 'dorianhernande'),
(4288, 1290180336, 2, 'unfreez'),
(4289, 1290180336, 2, 'eldenhilston911'),
(4290, 1290180336, 2, 'mrsuwan22nu'),
(4291, 1290180336, 2, 'donkeykong'),
(4292, 1290180336, 2, 'johnnders'),
(4293, 1290180336, 2, 'linarobina'),
(4294, 1290180336, 2, 'expats'),
(4295, 1290180336, 2, 'wayne93trujillo'),
(4296, 1290180336, 2, 'francismirnessa'),
(4297, 1290180336, 2, 'dorianhernande'),
(4298, 1290180336, 2, 'korgrandp1'),
(4299, 1290180336, 2, 'ward7mcgee'),
(4300, 1290180336, 2, 'dancelwet'),
(4301, 1290180336, 2, 'daugroy'),
(4302, 1290180336, 2, 'AbsWorkoutGenius62'),
(4303, 1290180336, 2, 'julyana'),
(4304, 1290180336, 2, 'GallantBMan'),
(4305, 1290180336, 2, 'JasPiks1'),
(4306, 1290180336, 2, 'johnyboy2157'),
(4307, 1290180336, 2, 'LLMackJack'),
(4308, 1290180336, 2, 'hubert7patrick'),
(4309, 1290180336, 2, 'Finance'),
(4310, 1290180336, 2, 'AuroINSEO'),
(4311, 1290180336, 2, 'keith5maynard'),
(4312, 1290180336, 2, 'crireetle'),
(4313, 1290180336, 2, 'Vartencensaws'),
(4314, 1290180336, 2, '19contest'),
(4315, 1290180336, 2, 'chance78velazque'),
(4316, 1290180336, 2, 'antwan3avery'),
(4317, 1290180336, 2, 'hghsupplementstore'),
(4318, 1290180336, 2, 'mimmo41catuso'),
(4319, 1290180336, 2, 'fblayout'),
(4320, 1290180336, 2, 'JohnDDaviess28'),
(4321, 1290180336, 2, 'timothybec22'),
(4322, 1290180336, 2, 'richarrdo62belll'),
(4323, 1290180336, 2, 'ilovesweets1966'),
(4324, 1290180336, 2, 'delmar84becker'),
(4325, 1290180336, 2, 'Hilife'),
(4326, 1290180336, 2, 'carmen92deleon'),
(4327, 1290180336, 2, 'dana38bennett'),
(4328, 1290180336, 2, 'daryl55dodson'),
(4329, 1290180336, 2, 'jelly22'),
(4330, 1290180336, 2, 'Marcus69Graham'),
(4331, 1290180336, 2, 'abah'),
(4332, 1290180336, 2, 'smileysok2'),
(4333, 1290180336, 2, 'kevin6clemons'),
(4334, 1290180336, 2, 'Adversawvaw'),
(4335, 1290180336, 2, 'AcouckAdjounk'),
(4336, 1290180336, 2, 'fishoil99'),
(4337, 1290180336, 2, 'jackie8austin'),
(4338, 1290180336, 2, 'emmanuelpkins90'),
(4339, 1290180336, 2, 'musclekertts'),
(4340, 1290180336, 2, 'robin28'),
(4341, 1290180336, 2, 'montrealdentist'),
(4342, 1290180336, 2, 'josaphine43hecok'),
(4343, 1290180336, 2, 'vibram5fingers2d'),
(4344, 1290180336, 2, 'spencer98terry'),
(4345, 1290180336, 2, 'RealEstateSeattle'),
(4346, 1290180336, 2, 'jay72craft'),
(4347, 1290180336, 2, 'JackT06'),
(4348, 1290180336, 2, 'tarot33'),
(4349, 1290180336, 2, 'worldofhair'),
(4350, 1290180336, 2, 'alphonse3clark'),
(4351, 1290180336, 2, 'jake233checkme'),
(4352, 1290180336, 2, 'omarmorin212'),
(4353, 1290180336, 2, 'ccssaran'),
(4354, 1290180336, 2, 'conrad52weiss'),
(4355, 1290180336, 2, 'taqueria2atlanta'),
(4356, 1290180336, 2, 'alinvera'),
(4357, 1290180336, 2, 'eliseo1ware'),
(4358, 1290180336, 2, 'josue64bright'),
(4359, 1290180336, 2, 'Indeksikqwe'),
(4360, 1290180336, 2, 'gettingbacktogether101'),
(4361, 1290180336, 2, 'Eneteamategaw'),
(4362, 1290180336, 2, 'devilishmuseum0'),
(4363, 1290180336, 2, 'maniacaljail99'),
(4364, 1290180336, 2, 'kurobe'),
(4365, 1290180336, 2, 'bernd7brodalkes'),
(4366, 1290180336, 2, 'devilishmuseum0'),
(4367, 1290180336, 2, 'BryanDulaney'),
(4368, 1290180336, 2, 'godebtrelief'),
(4369, 1290180336, 2, 'Tomcrowell12'),
(4370, 1290180336, 2, 'lucien6vang'),
(4371, 1290180336, 2, 'nestor8boone'),
(4372, 1290180336, 2, 'ryan35keller'),
(4373, 1290180336, 2, 'trijaya9q2kusuma'),
(4374, 1290180336, 2, 'grant7pell'),
(4375, 1290180336, 2, 'cruisedeals0'),
(4376, 1290180336, 2, 'Ferguson100'),
(4377, 1290180336, 2, 'clinton6maxwell'),
(4378, 1290180336, 2, 'cyrus96torres'),
(4379, 1290180336, 2, 'myles3sosa'),
(4380, 1290180336, 2, 'clyde47hess'),
(4381, 1290180336, 2, 'topwebhosts'),
(4382, 1290180336, 2, 'kindlemacken'),
(4383, 1290180336, 2, 'coachblack'),
(4384, 1290180336, 2, 'rampantbelfry59'),
(4385, 1290180336, 2, 'platformrisers'),
(4386, 1290180336, 2, 'swdejesus88'),
(4387, 1290180336, 2, 'Nicky'),
(4388, 1290180336, 2, 'yaz11'),
(4389, 1290180336, 2, 'tristan1thornton'),
(4390, 1290180336, 2, 'Capsiplex'),
(4391, 1290180336, 2, 'carobond24'),
(4392, 1290180336, 2, 'entertainmentlaw'),
(4393, 1290180336, 2, 'reindhy22'),
(4394, 1290180336, 2, 'saintygroup'),
(4395, 1290180336, 2, 'foodsjhe48'),
(4396, 1290180336, 2, 'Jagohieh9'),
(4397, 1290180336, 2, 'sushma12'),
(4398, 1290180336, 2, 'christian17leona'),
(4399, 1290180336, 2, 'bhandarigroup'),
(4400, 1290180336, 2, 'jennykheif'),
(4401, 1290180336, 2, 'eugene73acosta'),
(4402, 1290180336, 2, 'grill_guy'),
(4403, 1290180336, 2, 'UtmenYpeth'),
(4404, 1290180336, 2, 'curlynaiserh88'),
(4405, 1290180336, 2, 'joe2942'),
(4406, 1290180336, 2, 'aleasecox23'),
(4407, 1290180336, 2, 'lakeisha93'),
(4408, 1290180336, 2, 'findoplysningendan'),
(4409, 1290180336, 2, 'ashley01'),
(4410, 1290180336, 2, 'nickolas74chang'),
(4411, 1290180336, 2, 'woodenastronomy'),
(4412, 1290180336, 2, 'Effitiledge'),
(4413, 1290180336, 2, 'Smensefuncdu'),
(4414, 1290180336, 2, 'kongomat8'),
(4415, 1290180336, 2, 'kongomat8'),
(4416, 1290180336, 2, 'ahockeyguy492'),
(4417, 1290180336, 2, 'dublyfury'),
(4418, 1290180336, 2, 'myronhward'),
(4419, 1290180336, 2, 'rashelmoni'),
(4420, 1290180336, 2, 'eli5dorsey3'),
(4421, 1290180336, 2, 'carey35lowe'),
(4422, 1290180336, 2, 'truboprofit991'),
(4423, 1290180336, 2, 'Thimmonsilly'),
(4424, 1290180336, 2, 'korvixgreenpq'),
(4425, 1290180336, 2, 'TT134'),
(4426, 1290180336, 2, 'wilbert2olson'),
(4427, 1290180336, 2, 'greg9jefferson'),
(4428, 1290180336, 2, 'Abogesoordged'),
(4429, 1290180336, 2, 'cavayero'),
(4430, 1290180336, 2, 'flyboy7'),
(4431, 1290180336, 2, 'grill_guy'),
(4432, 1290180336, 2, 'pirtespraa'),
(4433, 1290180336, 2, 'nbabiweekly49'),
(4434, 1290180336, 2, 'Effitiledge'),
(4435, 1290180336, 2, 'emipiexassist'),
(4436, 1290180336, 2, 'roosevelt6wagner'),
(4437, 1290180336, 2, 'agustin5durham'),
(4438, 1290180336, 2, 'statueliberty322'),
(4439, 1290180336, 2, 'phicox54'),
(4440, 1290180336, 2, 'pedrnichol27'),
(4441, 1290180336, 2, 'jiloz1501'),
(4442, 1290180336, 2, 'gene39cochran'),
(4443, 1290180336, 2, 'garmin310xt81'),
(4444, 1290180336, 2, 'Diyaaldin121'),
(4445, 1290180336, 2, 'jacobwilliam10'),
(4446, 1290180336, 2, 'margarito95bonne'),
(4447, 1290180336, 2, 'waterfiltersf'),
(4448, 1290180336, 2, 'Pritts679'),
(4449, 1290180336, 2, 'jacques9short'),
(4450, 1290180336, 2, 'flexcin483'),
(4451, 1290180336, 2, 'averagenominee3'),
(4452, 1290180336, 2, 'Booqifu57'),
(4453, 1290180336, 2, 'dandrak49'),
(4454, 1290180336, 2, 'braviasss'),
(4455, 1290180336, 2, 'Neerajsingh'),
(4456, 1290180336, 2, 'smokedeter499'),
(4457, 1290180336, 2, 'Preston356'),
(4458, 1290180336, 2, 'stacey3cash'),
(4459, 1290180336, 2, 'ohioboy27'),
(4460, 1290180336, 2, 'faustino4bayer'),
(4461, 1290180336, 2, 'Davidbush'),
(4462, 1290180336, 2, 'miles9goff'),
(4463, 1290180336, 2, 'jenaglo23'),
(4464, 1290180336, 2, 'raymundo343hahn'),
(4465, 1290180336, 2, 'cyril92townsend'),
(4466, 1290180336, 2, 'gem1paye'),
(4467, 1290180336, 2, 'lessaccount12'),
(4468, 1290180336, 2, 'onlineprint'),
(4469, 1290180336, 2, 'finalround'),
(4470, 1290180336, 2, 'gracedey84'),
(4471, 1290180336, 2, 'hans173amrst'),
(4472, 1290180336, 2, 'Elmo65492'),
(4473, 1290180336, 2, 'TyshawnJagger'),
(4474, 1290180336, 2, 'khseh4'),
(4475, 1290180336, 2, 'derrick88malone'),
(4476, 1290180336, 2, 'jamesaddison'),
(4477, 1290180336, 2, 'steven1987mcknight'),
(4478, 1290180336, 2, 'barrel fiend'),
(4479, 1290180336, 2, 'bluecolorme'),
(4480, 1290180336, 2, 'donnie2dillard'),
(4481, 1290180336, 2, 'gucci joy'),
(4482, 1290180336, 2, 'flower12'),
(4483, 1290180336, 2, 'green4david'),
(4484, 1290180336, 2, 'backlinks3rvice'),
(4485, 1290180336, 2, 'hattazna1z'),
(4486, 1290180336, 2, 'jmko1200'),
(4487, 1290180336, 2, 'charleyoak'),
(4488, 1290180336, 2, 'billigawebbhotell'),
(4489, 1290180336, 2, 'kim25matthews'),
(4490, 1290180336, 2, 'sandratran2010'),
(4491, 1290180336, 2, 'outsourcemybuttoffman69'),
(4492, 1290180336, 2, 'dewey661shepherd'),
(4493, 1290180336, 2, 'mickhhp9'),
(4494, 1290180336, 2, 'thenpartyvenue5y'),
(4495, 1290180336, 2, 'cody4mclean'),
(4496, 1290180336, 2, 'don2blakney'),
(4497, 1290180336, 2, 'biotinandhairloss89'),
(4498, 1290180336, 2, 'bosedock4u'),
(4499, 1290180336, 2, 'clydeclarke'),
(4500, 1290180336, 2, 'korvixtorraninh'),
(4501, 1290180336, 2, 'web20keywordfinder'),
(4502, 1290180336, 2, 'dominic41gordon'),
(4503, 1290180336, 2, 'rubyclark777'),
(4504, 1290180336, 2, 'diet73'),
(4505, 1290180336, 2, 'fleming38'),
(4506, 1290180336, 2, 'watchlivetvonlinee'),
(4507, 1290180336, 2, 'marion5nicholson'),
(4508, 1290180336, 2, 'jamal32mcgeezz'),
(4509, 1290180336, 2, 'joeyj909'),
(4510, 1290180336, 2, 'sydneysolar'),
(4511, 1290180336, 2, 'p261i9k1'),
(4512, 1290180336, 2, 'daily_fx_scam'),
(4513, 1290180336, 2, 'xtranewss915'),
(4514, 1290180336, 2, 'ulla2mccullough'),
(4515, 1290180336, 2, 'DunWhite1'),
(4516, 1290180336, 2, 'russel94reeves'),
(4517, 1290180336, 2, 'johnnuthalls'),
(4518, 1290180336, 2, 'emipiexassist'),
(4519, 1290180336, 2, 'bridalmakeupartist'),
(4520, 1290180336, 2, 'franklin1hinton'),
(4521, 1290180336, 2, 'greesoste'),
(4522, 1290180336, 2, 'otis15barner'),
(4523, 1290180336, 2, 'breast311'),
(4524, 1290180336, 2, 'MarBorDraiz'),
(4525, 1290180336, 2, 'Bellufino'),
(4526, 1290180336, 2, 'solarmodules'),
(4527, 1290180336, 2, 'itrendytrend'),
(4528, 1290180336, 2, 'rafael57guerra'),
(4529, 1290180336, 2, 'enrique45solis'),
(4530, 1290180336, 2, 'lane35cleveland'),
(4531, 1290180336, 2, 'beverson24'),
(4532, 1290180336, 2, 'Leonard001'),
(4533, 1290180336, 2, 'DarrellDallum'),
(4534, 1290180336, 2, 'pualgails22'),
(4535, 1290180336, 2, 'young57roy'),
(4536, 1290180336, 2, 'dianawink555'),
(4537, 1290180336, 2, 'eth3n23schu4tz');
INSERT INTO `#__sl_SpamFilter` (`id`, `time`, `type`, `term`) VALUES
(4538, 1290180336, 2, 'henrikkpedersen1'),
(4539, 1290180336, 2, 'Razi6x'),
(4540, 1290180336, 2, 'bossy46'),
(4541, 1290180336, 2, 'decoratingbath'),
(4542, 1290180336, 2, 'pearlypapules49'),
(4543, 1290180336, 2, 'bilalhabib28'),
(4544, 1290180336, 2, 'george87stevano'),
(4545, 1290180336, 2, 'nichopeter23'),
(4546, 1290180336, 2, 'pennystockprophet347'),
(4547, 1290180336, 2, 'lemm5baye'),
(4548, 1290180336, 2, 'tracy69blevins'),
(4549, 1290180336, 2, 'jonas9hutchinson'),
(4550, 1290180336, 2, 'august85valdez'),
(4551, 1290180336, 2, 'linwood7ewing'),
(4552, 1290180336, 2, 'clayton49puckett'),
(4553, 1290180336, 2, 'PadroYgedes5'),
(4554, 1290180336, 2, 'living2010'),
(4555, 1290180336, 2, 'topbusinessschools'),
(4556, 1290180336, 2, 'songket18'),
(4557, 1290180336, 2, 'jeffersonrollers'),
(4558, 1290180336, 2, 'elwoodizzzo'),
(4559, 1290180336, 2, 'freddy46'),
(4560, 1290180336, 2, 'latinah2g2sumijah'),
(4561, 1290180336, 2, 'healthyDetox'),
(4562, 1290180336, 2, '123BabyFurniture4321'),
(4563, 1290180336, 2, 'goofychick100'),
(4564, 1290180336, 2, 'Nasdfmhg'),
(4565, 1290180336, 2, 'weldon78burris'),
(4566, 1290180336, 2, 'KeanaCollin'),
(4567, 1290180336, 2, 'rywarren'),
(4568, 1290180336, 2, 'monty67tanner'),
(4569, 1290180336, 2, 'bloggingforbeginners'),
(4570, 1290180336, 2, 'gerry8whitney'),
(4571, 1290180336, 2, 'jerome3johns'),
(4572, 1290180336, 2, 'maglighw9'),
(4573, 1290180336, 2, 'baseball247shop'),
(4574, 1290180336, 2, 'srhhayley'),
(4575, 1290180336, 2, 'harlan4pitts'),
(4576, 1290180336, 2, 'harlan4pitts'),
(4577, 1290180336, 2, 'acunitlover'),
(4578, 1290180336, 2, 'Mondelli458'),
(4579, 1290180336, 2, 'marathonmile56'),
(4580, 1290180336, 2, 'jeffersonrollers'),
(4581, 1290180336, 2, 'tracy69blevins'),
(4582, 1290180336, 2, 'BlotitoXY'),
(4583, 1290180336, 2, 'MarBorDraiz'),
(4584, 1290180336, 2, 'Orellabac'),
(4585, 1290180336, 2, 'lovehenna'),
(4586, 1290180336, 2, 'puppyvarf21'),
(4587, 1290180336, 2, 'imeads123'),
(4588, 1290180336, 2, 'stacey2stanley'),
(4589, 1290180336, 2, 'toby67lott'),
(4590, 1290180336, 2, 'sexytimez'),
(4591, 1290180336, 2, 'yamraj0101'),
(4592, 1290180336, 2, 'lil_wayne_new_mixtape'),
(4593, 1290180336, 2, 'juan13frank'),
(4594, 1290180336, 2, 'oilwellsforsale100'),
(4595, 1290180336, 2, 'woodrow87fox'),
(4596, 1290180336, 2, 'orville2merritt'),
(4597, 1290180336, 2, 'fxchildsplays10'),
(4598, 1290180336, 2, 'sandralohan84'),
(4599, 1290180336, 2, 'dentalfloss2010'),
(4600, 1290180336, 2, 'wilburn22hatfiel'),
(4601, 1290180336, 2, 'rem001'),
(4602, 1290180336, 2, 'colocation'),
(4603, 1290180336, 2, 'alden88collins'),
(4604, 1290180336, 2, 'geazest1'),
(4605, 1290180336, 2, 'mtg007'),
(4606, 1290180336, 2, 'thomsannager1'),
(4607, 1290180336, 2, 'lieunh1105'),
(4608, 1290180336, 2, 'idprotectionkeith'),
(4609, 1290180336, 2, 'hector83bullock'),
(4610, 1290180336, 2, 'hotelsbarcelona'),
(4611, 1290180336, 2, 'menashe8campos'),
(4612, 1290180336, 2, 'pet0fan3'),
(4613, 1290180336, 2, 'bagus9r1yulianto'),
(4614, 1290180336, 2, 'GaishMipRaise'),
(4615, 1290180336, 2, 'ares1307'),
(4616, 1290180336, 2, 'emipiexassist'),
(4617, 1290180336, 2, 'AcouckAdjounk'),
(4618, 1290180336, 2, 'TraurneJurfagenulk'),
(4619, 1290180336, 2, 'tomas56osiswanto'),
(4620, 1290180336, 2, 'sterlingemerson55'),
(4621, 1290180336, 2, 'kaka06'),
(4622, 1290180336, 2, 'shokz2sc'),
(4623, 1290180336, 2, 'gordonrmueller'),
(4624, 1290180336, 2, 'jimmie19knapp'),
(4625, 1290180336, 2, 'tyson37webster'),
(4626, 1290180336, 2, 'automotiveparts3'),
(4627, 1290180336, 2, 'mobile_guy'),
(4628, 1290180336, 2, 'antoine9stevens'),
(4629, 1290180336, 2, 'shirley200'),
(4630, 1290180336, 2, 'frankdouglas'),
(4631, 1290180336, 2, 'Photovoltaik'),
(4632, 1290180336, 2, 'gio6sipra'),
(4633, 1290180336, 2, 'Koral'),
(4634, 1290180336, 2, 'healthyarticles1'),
(4635, 1290180336, 2, 'the101dan'),
(4636, 1290180336, 2, 'angya85sultes'),
(4637, 1290180336, 2, 'natasha29degelop'),
(4638, 1290180336, 2, 'hadi7j4darwanto'),
(4639, 1290180336, 2, 'marlon9barrett'),
(4640, 1290180336, 2, 'hubert97harrison'),
(4641, 1290180336, 2, 'marcel18moran'),
(4642, 1290180336, 2, 'howard22melendez'),
(4643, 1290180336, 2, 'haidivolum'),
(4644, 1290180336, 2, 'keyreedaai'),
(4645, 1290180336, 2, 'anatoliy38'),
(4646, 1290180336, 2, 'ecakubra'),
(4647, 1290180336, 2, 'SilverJanice'),
(4648, 1290180336, 2, 'coleman5waters'),
(4649, 1290180336, 2, 'orban66benzi'),
(4650, 1290180336, 2, 'Grant13bradshaw'),
(4651, 1290180336, 2, 'raythomasn'),
(4652, 1290180336, 2, 'Tradecopier443'),
(4653, 1290180336, 2, 'emmett91michael'),
(4654, 1290180336, 2, 'roy4zamora'),
(4655, 1290180336, 2, 'thesmokebot001'),
(4656, 1290180336, 2, 'russ49duncan'),
(4657, 1290180336, 2, 'Lianein'),
(4658, 1290180336, 2, 'dewey6white'),
(4659, 1290180336, 2, 'luis1fox'),
(4660, 1290180336, 2, 'augustine8pachec'),
(4661, 1290180336, 2, 'fenninill'),
(4662, 1290180336, 2, 'doggiedaycare'),
(4663, 1290180336, 2, 'krishparmardin'),
(4664, 1290180336, 2, 'beth02manning'),
(4665, 1290180336, 2, 'Advicespots101'),
(4666, 1290180336, 2, 'mickey6gutierrez'),
(4667, 1290180336, 2, 'salenics'),
(4668, 1290180336, 2, 'manycriminals'),
(4669, 1290180336, 2, 'lawman20'),
(4670, 1290180336, 2, 'forest29gay'),
(4671, 1290180336, 2, 'grover744sharp'),
(4672, 1290180336, 2, 'wilburn89barron'),
(4673, 1290180336, 2, 'ccna_certificates'),
(4674, 1290180336, 2, 'laundrybasketonwheels24'),
(4675, 1290180336, 2, 'nicolas3butler'),
(4676, 1290180336, 2, 'songket3'),
(4677, 1290180336, 2, 'leatherfurniturestores12'),
(4678, 1290180336, 2, 'eli56chandler'),
(4679, 1290180336, 2, 'besthomeownerloans8'),
(4680, 1290180336, 2, 'laserhairremoval14'),
(4681, 1290180336, 2, 'MandDyncHeday'),
(4682, 1290180336, 2, 'Fennanock'),
(4683, 1290180336, 2, 'scottie99ortiz'),
(4684, 1290180336, 2, 'noah7myers'),
(4685, 1290180336, 2, 'tallgathering40'),
(4686, 1290180336, 2, 'base3242'),
(4687, 1290180336, 2, 'emanuel58obrien'),
(4688, 1290180336, 2, 'makingcontact'),
(4689, 1290180336, 2, 'emanuel58obrien'),
(4690, 1290180336, 2, 'tony29keers'),
(4691, 1290180336, 2, 'bourneseo'),
(4692, 1290180336, 2, 'steve85eddie'),
(4693, 1290180336, 2, 'vupu737zeo'),
(4694, 1290180336, 2, 'donnell69cash'),
(4695, 1290180336, 2, 'pekane30'),
(4696, 1290180336, 2, 'redundanttheory'),
(4697, 1290180336, 2, 'dan12james'),
(4698, 1290180336, 2, 'duhale80'),
(4699, 1290180336, 2, 'Juliafedrsts'),
(4700, 1290180336, 2, 'ares1307'),
(4701, 1290180336, 2, 'cheappool'),
(4702, 1290180336, 2, 'ValorDT'),
(4703, 1290180336, 2, 'nolan7lee'),
(4704, 1290180336, 2, 'juliobaker888'),
(4705, 1290180336, 2, 'markbranigans'),
(4706, 1290180336, 2, 'sydney75mccarty'),
(4707, 1290180336, 2, 'wilfred1richards'),
(4708, 1290180336, 2, 'unlockiphone4g2'),
(4709, 1290180336, 2, 'KevinEberbach'),
(4710, 1290180336, 2, 'findcar3'),
(4711, 1290180336, 2, 'wilfred1richards'),
(4712, 1290180336, 2, 'manutdfc2010'),
(4713, 1290180336, 2, 'steve85eddie'),
(4714, 1290180336, 2, 'dr0idx'),
(4715, 1290180336, 2, 'footballmagnets'),
(4716, 1290180336, 2, 'nathaniel3hardin'),
(4717, 1290180336, 2, 'nelsonayo27'),
(4718, 1290180336, 2, 'benoit53beaulne'),
(4719, 1290180336, 2, 'hingtonklarsey'),
(4720, 1290180336, 2, 'WorldDating'),
(4721, 1290180336, 2, 'antoine25salazar'),
(4722, 1290180336, 2, 'roderick38owens'),
(4723, 1290180336, 2, 'ResveratrolBabes'),
(4724, 1290180336, 2, 'george4sandoval'),
(4725, 1290180336, 2, '!!Melissa213!!'),
(4726, 1290180336, 2, 'cyrusmanus'),
(4727, 1290180336, 2, 'reid89sosa'),
(4728, 1290180336, 2, 'edward33battle'),
(4729, 1290180336, 2, 'clark9marshall'),
(4730, 1290180336, 2, 'javier8morton'),
(4731, 1290180336, 2, 'thomsannager1'),
(4732, 1290180336, 2, 'keyreedaai'),
(4733, 1290180336, 2, 'sonny15hess'),
(4734, 1290180336, 2, 'reynaldo9buckner'),
(4735, 1290180336, 2, 'dunhamdhoes'),
(4736, 1290180336, 2, 'bryce5tran'),
(4737, 1290180336, 2, 'wallace58meadows'),
(4738, 1290180336, 2, 'lane16vega'),
(4739, 1290180336, 2, 'sheena89liveosle'),
(4740, 1290180336, 2, 'sikelair86'),
(4741, 1290180336, 2, 'adamauton45'),
(4742, 1290180336, 2, 'pcabaretparty44t'),
(4743, 1290180336, 2, 'swimsuits'),
(4744, 1290180336, 2, 'pedro6pollard'),
(4745, 1290180336, 2, 'infoproductkiller'),
(4746, 1290180336, 2, 'jbutler83'),
(4747, 1290180336, 2, 'ClemSnideL79'),
(4748, 1290180336, 2, 'hans99butler'),
(4749, 1290180336, 2, 'atl32wynn'),
(4750, 1290180336, 2, 'billybahbah79'),
(4751, 1290180336, 2, 'clarence93glass'),
(4752, 1290180336, 2, 'dusty1reilly9'),
(4753, 1290180336, 2, 'houston4burks'),
(4754, 1290180336, 2, 'randycook'),
(4755, 1290180336, 2, 'naturallygrowbreasts'),
(4756, 1290180336, 2, 'freecollegeinfo83'),
(4757, 1290180336, 2, 'brettsmith63'),
(4758, 1290180336, 2, 'humveewatson'),
(4759, 1290180336, 2, 'boyd24hess'),
(4760, 1290180336, 2, 'tablemagician'),
(4761, 1290180336, 2, 'likea219'),
(4762, 1290180336, 2, 'webhosting9'),
(4763, 1290180336, 2, 'clair2frazier'),
(4764, 1290180336, 2, 'coy3pollard4'),
(4765, 1290180336, 2, 'ricky4mann'),
(4766, 1290180336, 2, 'solomon4sutton'),
(4767, 1290180336, 2, 'dean86mueller'),
(4768, 1290180336, 2, 'harvey4luna'),
(4769, 1290180336, 2, 'hospital51'),
(4770, 1290180336, 2, 'shoshi78reynolds'),
(4771, 1290180336, 2, 'onlinedyslexiatest'),
(4772, 1290180336, 2, 'meganparish777'),
(4773, 1290180336, 2, 'Mangkuk365'),
(4774, 1290180336, 2, 'iPodFixt105'),
(4775, 1290180336, 2, 'emery9byers'),
(4776, 1290180336, 2, 'kathynature84'),
(4777, 1290180336, 2, 'ceslie8310'),
(4778, 1290180336, 2, 'ismael2bowen'),
(4779, 1290180336, 2, 'thomas33dillon'),
(4780, 1290180336, 2, 'kyle9henry'),
(4781, 1290180336, 2, 'solomon12reeves'),
(4782, 1290180336, 2, 'allen66vasquez'),
(4783, 1290180336, 2, 'mike843notebookflat'),
(4784, 1290180336, 2, 'myles98roberts'),
(4785, 1290180336, 2, 'mjames84'),
(4786, 1290180336, 2, 'kairte1bkairte'),
(4787, 1290180336, 2, 'ihennightlondon94q'),
(4788, 1290180336, 2, 'carlton1diaz'),
(4789, 1290180336, 2, 'salt2010'),
(4790, 1290180336, 2, 'jer18sot'),
(4791, 1290180336, 2, 'doyle32hensley'),
(4792, 1290180336, 2, 'omar72wallace'),
(4793, 1290180336, 2, 'vernon91duran'),
(4794, 1290180336, 2, 'sandra43kloiber'),
(4795, 1290180336, 2, 'robbie93walsh'),
(4796, 1290180336, 2, 'OrlandoIniguez'),
(4797, 1290180336, 2, 'lickherefreecruise'),
(4798, 1290180336, 2, 'Ronald250'),
(4799, 1290180336, 2, 'bikecomputerxx040'),
(4800, 1290180336, 2, 'mabeljones888'),
(4801, 1290180336, 2, 'robbie93walsh'),
(4802, 1290180336, 2, 'oliviaperryslu960'),
(4803, 1290180336, 2, 'kendall97ramsey'),
(4804, 1290180336, 2, 'jane69'),
(4805, 1290180336, 2, 'sdseoB1904'),
(4806, 1290180336, 2, 'uhenpartylondon94v'),
(4807, 1290180336, 2, 'alowens81'),
(4808, 1290180336, 2, 'garrett15hawk12ns'),
(4809, 1290180336, 2, 'kerry7carson'),
(4810, 1290180336, 2, 'matthewwise2010'),
(4811, 1290180336, 2, 'larry7owens'),
(4812, 1290180336, 2, 'jefferson95harvey'),
(4813, 1290180336, 2, 'demetrius82mccal'),
(4814, 1290180336, 2, 'laveirneiichair'),
(4815, 1290180336, 2, 'lotterymethod101'),
(4816, 1290180336, 2, 'gsheldonbuyer'),
(4817, 1290180336, 2, 'aron85lewis'),
(4818, 1290180336, 2, 'bingocafeuk'),
(4819, 1290180336, 2, 'lincoln5rodrique'),
(4820, 1290180336, 2, 'reynaldo7booker'),
(4821, 1290180336, 2, 'guempempe'),
(4822, 1290180336, 2, 'gregmac037'),
(4823, 1290180336, 2, 'expats26'),
(4824, 1290180336, 2, 'paitoon'),
(4825, 1290180336, 2, 'jasonkottke12'),
(4826, 1290180336, 2, 'jeffery15bush'),
(4827, 1290180336, 2, 'stan5forn'),
(4828, 1290180336, 2, 'johnson12'),
(4829, 1290180336, 2, 'jamal39mcgee'),
(4830, 1290180336, 2, 'clint33fields22'),
(4831, 1290180336, 2, 'tony69hood'),
(4832, 1290180336, 2, 'armand33buckley'),
(4833, 1290180336, 2, 'errol61stanton'),
(4834, 1290180336, 2, 'kubhncay251'),
(4835, 1290180336, 2, 'spacened9'),
(4836, 1290180336, 2, 'floyd29lester'),
(4837, 1290180336, 2, 'quiny5855suarez'),
(4838, 1290180336, 2, 'geoffreysheppar1'),
(4839, 1290180336, 2, 'angel57montoya'),
(4840, 1290180336, 2, 'gale6hurst'),
(4841, 1290180336, 2, 'coy5pollard5'),
(4842, 1290180336, 2, 'atir3hussain'),
(4843, 1290180336, 2, 'obert99dowries'),
(4844, 1290180336, 2, 'selection_code'),
(4845, 1290180336, 2, 'cameron86mcgowan'),
(4846, 1290180336, 2, 'tohateh2010'),
(4847, 1290180336, 2, 'dermeyerma49'),
(4848, 1290180336, 2, 'freecollegeinfo42hgn429'),
(4849, 1290180336, 2, 'kenneth1jacobson'),
(4850, 1290180336, 2, 'otis3bass'),
(4851, 1290180336, 2, 'colby7sears'),
(4852, 1290180336, 2, 'houseandland'),
(4853, 1290180336, 2, 'emily23parks'),
(4854, 1290180336, 2, 'major1vincent'),
(4855, 1290180336, 2, 'wenas9q6budiono'),
(4856, 1290180336, 2, 'bambang2w5triatmo'),
(4857, 1290180336, 2, 'moneyz778'),
(4858, 1290180336, 2, 'edwardfgz'),
(4859, 1290180336, 2, 'futuristiccharl'),
(4860, 1290180336, 2, 'JBradell123'),
(4861, 1290180336, 2, 'orvillecasex901'),
(4862, 1290180336, 2, 'BAlovie'),
(4863, 1290180336, 2, 'Billyy'),
(4864, 1290180336, 2, 'somantos'),
(4865, 1290180336, 2, 'permondinix'),
(4866, 1290180336, 2, 'simongrant49'),
(4867, 1290180336, 2, 'elinaelberta'),
(4868, 1290180336, 2, 'Generic Viagra'),
(4869, 1290180336, 2, 'CarolFoster1'),
(4870, 1290180336, 2, 'thomataylor23'),
(4871, 1290180336, 2, 'sunglasses'),
(4872, 1290180336, 2, 'puzzelesgames'),
(4873, 1290180336, 2, 'davisrenee'),
(4874, 1290180336, 2, 'DavidLBoyd'),
(4875, 1290180336, 2, 'martinirvine25'),
(4876, 1290180336, 2, 'marystephen'),
(4877, 1290180336, 2, 'ashosew123'),
(4878, 1290180336, 2, 'eurodisneystaff'),
(4879, 1290180336, 2, 'ternjealt'),
(4880, 1290180336, 2, 'firmeluminoasew'),
(4881, 1290180336, 2, 'consumabilemedicalen'),
(4882, 1290180336, 2, 'cod comercialr'),
(4883, 1290180336, 2, 'cerceiargintl'),
(4884, 1290180336, 2, 'bursadetransporta'),
(4885, 1290180336, 2, 'transportu'),
(4886, 1290180336, 2, 'maziedesland'),
(4887, 1290180336, 2, 'adeshbhusan'),
(4888, 1290180336, 2, 'denizkokenkimdir4'),
(4889, 1290180336, 2, 'homelessdarlingad'),
(4890, 1290180336, 2, 'MoldingChic'),
(4891, 1290180336, 2, 'infraredconcepts'),
(4892, 1290180336, 2, 'brianmorfs01'),
(4893, 1290180336, 2, 'buildchestmuscles'),
(4894, 1290180336, 2, 'ArrarseQuotte'),
(4895, 1290180336, 2, 'Billyy'),
(4896, 1290180336, 2, 'Johnsolf'),
(4897, 1290180336, 2, 'travels'),
(4898, 1290180336, 2, 'TimbJamiNains'),
(4899, 1290180336, 2, 'RhysHe'),
(4900, 1290180336, 2, 'Bassiou'),
(4901, 1290180336, 2, 'ellis0377'),
(4902, 1290180336, 2, 'owenruiza12'),
(4903, 1290180336, 2, 'boss.hacker89'),
(4904, 1290180336, 2, 'shane982williams'),
(4905, 1290180336, 2, 'anderson6bryant'),
(4906, 1290180336, 2, 'travolta10'),
(4907, 1290180336, 2, 'Nose_smaller'),
(4908, 1290180336, 2, 'ArrarseQuotte'),
(4909, 1290180336, 2, 'pobierzcos'),
(4910, 1290180336, 2, 'ignacio9stephens'),
(4911, 1290180336, 2, 'kiermilton'),
(4912, 1290180336, 2, 'BFdinah'),
(4913, 1290180336, 2, 'BeeHawley'),
(4914, 1290180336, 2, 'jansenm18'),
(4915, 1290180336, 2, 'brianmorfs01'),
(4916, 1290180336, 2, 'parisfrancia'),
(4917, 1290180336, 2, 'ginebra'),
(4918, 1290180336, 2, 'alva7mckinpar'),
(4919, 1290180336, 2, 'deluxgoodnew'),
(4920, 1290180336, 2, 'HOsid'),
(4921, 1290180336, 2, 'Mariathomas'),
(4922, 1290180336, 2, 'lht192'),
(4923, 1290180336, 2, 'basil731'),
(4924, 1290180336, 2, 'domainhost'),
(4925, 1290180336, 2, 'philiple'),
(4926, 1290180336, 2, 'Akilar123'),
(4927, 1290180336, 2, 'kennrner7'),
(4928, 1290180336, 2, 'mervine49nielsen'),
(4929, 1290180336, 2, 'smithira21'),
(4930, 1290180336, 2, 'SheidlerGilbert184'),
(4931, 1290180336, 2, 'OutlawLover'),
(4932, 1290180336, 2, 'nephira19'),
(4933, 1290180336, 2, 'mwayne01'),
(4934, 1290180336, 2, 'johnmakarenko'),
(4935, 1290180336, 2, 'AddieT83'),
(4936, 1290180336, 2, 'lucievfedrrikts'),
(4937, 1290180336, 2, 'pinestip'),
(4938, 1290180336, 2, 'markingram6'),
(4939, 1290180336, 2, 'guideline'),
(4940, 1290180336, 2, 'GloomilyFragile'),
(4941, 1290180336, 2, 'CVvannesa'),
(4942, 1290180336, 2, 'krishna'),
(4943, 1290180336, 2, 'dragon88'),
(4944, 1290180336, 2, 'johnkyth'),
(4945, 1290180336, 2, 'usman201008'),
(4946, 1290180336, 2, 'excelhelp'),
(4947, 1290180336, 2, 'dreamdancer'),
(4948, 1290180336, 2, 'Bernetta'),
(4949, 1290180336, 2, 'MoikeZetMeafe'),
(4950, 1290180336, 2, 'weightlossboxx'),
(4951, 1290180336, 2, 'firstlalimo'),
(4952, 1290180336, 2, 'stewart66owens'),
(4953, 1290180336, 2, 'Oathkeeper'),
(4954, 1290180336, 2, 'computergeekspeed'),
(4955, 1290180336, 2, 'debtrelief123'),
(4956, 1290180336, 2, 'LikeMyShare'),
(4957, 1290180336, 2, 'djohnson906'),
(4958, 1290180336, 2, 'salesmlm12'),
(4959, 1290180336, 2, 'QQtanisha'),
(4960, 1290180336, 2, 'trastrap'),
(4961, 1290180336, 2, 'satellite12'),
(4962, 1290180336, 2, 'soveMigovoppy'),
(4963, 1290180336, 2, 'roke'),
(4964, 1290180336, 2, 'satellite12'),
(4965, 1290180336, 2, 'Zaznqaakl'),
(4966, 1290180336, 2, 'Gaus Rafi'),
(4967, 1290180336, 2, 'devlega985'),
(4968, 1290180336, 2, 'hundun'),
(4969, 1290180336, 2, 'richardsuryajaya'),
(4970, 1290180336, 2, 'uniformmeet'),
(4971, 1290180336, 2, 'BLrefugio'),
(4972, 1290180336, 2, 'Magimmuxugh'),
(4973, 1290180336, 2, 'nolan19bray'),
(4974, 1290180336, 2, 'hosting'),
(4975, 1290180336, 2, 'Pemorargo'),
(4976, 1290180336, 2, 'bhuvana'),
(4977, 1290180336, 2, 'fashion2k10pro'),
(4978, 1290180336, 2, 'srdjananderson5269'),
(4979, 1290180336, 2, 'swankybarrel53'),
(4980, 1290180336, 2, 'smithed1982'),
(4981, 1290180336, 2, 'Insernifari'),
(4982, 1290180336, 2, 'noithuy123'),
(4983, 1290180336, 2, 'chadchau13'),
(4984, 1290180336, 2, 'historicalspect'),
(4985, 1290180336, 2, 'goodmanupstairs'),
(4986, 1290180336, 2, 'liaillenlarve'),
(4987, 1290180336, 2, 'WZgarnett'),
(4988, 1290180336, 2, 'Gaus Rafi'),
(4989, 1290180336, 2, 'damac012'),
(4990, 1290180336, 2, 'oldfroglet'),
(4991, 1290180336, 2, 'glacegrafix'),
(4992, 1290180336, 2, 'clickhall1957'),
(4993, 1290180336, 2, 'saul4pearson'),
(4994, 1290180336, 2, 'cheapkamagra'),
(4995, 1290180336, 2, 'CEbrooks'),
(4996, 1290180336, 2, 'bestonlinebetfree'),
(4997, 1290180336, 2, 'mel44wyat'),
(4998, 1290180336, 2, 'wetooelj82'),
(4999, 1290180336, 2, '11x17_binders'),
(5000, 1290180336, 2, 'OBkerri'),
(5001, 1290180336, 2, 'implanturicardiace'),
(5002, 1290180336, 2, 'mooncake123'),
(5003, 1290180336, 2, 'JWathena'),
(5004, 1290180336, 2, 'adrtech'),
(5005, 1290180336, 2, 'jordonlikins'),
(5006, 1290180336, 2, 'coltchicken'),
(5007, 1290180336, 2, 'hostingreviewworld'),
(5008, 1290180336, 2, 'benante'),
(5009, 1290180336, 2, 'tommie58hicks'),
(5010, 1290180336, 2, 'ZBmaura'),
(5011, 1290180336, 2, 'pa1111'),
(5012, 1290180336, 2, 'Enetecavytymn'),
(5013, 1290180336, 2, 'shirtsxxl'),
(5014, 1290180336, 2, 'permondinix'),
(5015, 1290180336, 2, 'Linaish'),
(5016, 1290180336, 2, 'addetaite'),
(5017, 1290180336, 2, 'GJludivina'),
(5018, 1290180336, 2, 'thompson44'),
(5019, 1290180336, 2, 'booker78clark'),
(5020, 1290180336, 2, 'desmond38duncan'),
(5021, 1290180336, 2, 'vernongetzler'),
(5022, 1290180336, 2, 'israeler9roth'),
(5023, 1290180336, 2, 'aldoy29'),
(5024, 1290180336, 2, 'tristian216516'),
(5025, 1290180336, 2, 'somantos'),
(5026, 1290180336, 2, 'onyszkou'),
(5027, 1290180336, 2, 'jasonred0118'),
(5028, 1290180336, 2, 'FrancisTZ'),
(5029, 1290180336, 2, 'jansenm23'),
(5030, 1290180336, 2, 'jasonred0118'),
(5031, 1290180336, 2, 'Yardy133'),
(5032, 1290180336, 2, 'freeindia33'),
(5033, 1290180336, 2, 'marriage_guru'),
(5034, 1290180336, 2, 'wordgames'),
(5035, 1290180336, 2, 'TenderZephyr'),
(5036, 1290180336, 2, 'cole94rios'),
(5037, 1290180336, 2, '42dianepacheco'),
(5038, 1290180336, 2, 'jeanniesmith1402960'),
(5039, 1290180336, 2, 'kenithworkman1960'),
(5040, 1290180336, 2, 'wade2campos'),
(5041, 1290180336, 2, 'Gene_Simons'),
(5042, 1290180336, 2, 'wade2campos'),
(5043, 1290180336, 2, 'HomeCleanerPro'),
(5044, 1290180336, 2, 'benito761jacobson'),
(5045, 1290180336, 2, 'rudolfcraighead'),
(5046, 1290180336, 2, 'medalofhonorfree'),
(5047, 1290180336, 2, 'WendyNixon'),
(5048, 1290180336, 2, 'brndette21'),
(5049, 1290180336, 2, 'ZenShoorgode'),
(5050, 1290180336, 2, 'jansenm20'),
(5051, 1290180336, 2, 'pierretom89'),
(5052, 1290180336, 2, 'SlightlyLurking'),
(5053, 1290180336, 2, 'jvolantas'),
(5054, 1290180336, 2, 'woodencrystalnk'),
(5055, 1290180336, 2, 'dricksen'),
(5056, 1290180336, 2, 'casey027'),
(5057, 1290180336, 2, 'melvin1clark31'),
(5058, 1290180336, 2, 'wilson86payne'),
(5059, 1290180336, 2, 'acai-berry-burn'),
(5060, 1290180336, 2, 'effects-of-snorting-'),
(5061, 1290180336, 2, 'LesboTrick'),
(5062, 1290180336, 2, 'BialoSniezka'),
(5063, 1290180336, 2, 'acomplia-online'),
(5064, 1290180336, 2, 'generic-fioricet'),
(5065, 1290180336, 2, 'roxy9mul'),
(5066, 1290180336, 2, 'kristopher29trev'),
(5067, 1290180336, 2, 'salvina5Stanlon'),
(5068, 1290180336, 2, 'leelee1948'),
(5069, 1290180336, 2, 'description-of-soma'),
(5070, 1290180336, 2, 'flouride-celexa'),
(5071, 1290180336, 2, 'Mendhathtette'),
(5072, 1290180336, 2, 'ZMmora'),
(5073, 1290180336, 2, 'order-viagra'),
(5074, 1290180336, 2, 'atlanta-accutane-law'),
(5075, 1290180336, 2, 'brennan-seroquel-dep'),
(5076, 1290180336, 2, 'viagra-without-presc'),
(5077, 1290180336, 2, 'Abnolcall'),
(5078, 1290180336, 2, 'aloofguidebookX'),
(5079, 1290180336, 2, 'levitra-review'),
(5080, 1290180336, 2, 'natural-viagra'),
(5081, 1290180336, 2, 'buy-acai-berry'),
(5082, 1290180336, 2, 'acai-berry-maxx'),
(5083, 1290180336, 2, 'warmvents11'),
(5084, 1290180336, 2, 'cheap-fioricet'),
(5085, 1290180336, 2, 'buying-viagra'),
(5086, 1290180336, 2, 'xanax-drug-interacti'),
(5087, 1290180336, 2, 'viagra-online'),
(5088, 1290180336, 2, 'tramadol-hydrochlori'),
(5089, 1290180336, 2, 'nbajordan'),
(5090, 1290180336, 2, 'UZdacia'),
(5091, 1290180336, 2, 'carseat99'),
(5092, 1290180336, 2, 'james911'),
(5093, 1290180336, 2, 'low-cost-cialis'),
(5094, 1290180336, 2, 'xanax-withdrawal'),
(5095, 1290180336, 2, 'celebrex-stroke'),
(5096, 1290180336, 2, 'ambien-and-alcohol'),
(5097, 1290180336, 2, 'klonopin-vs-xanax'),
(5098, 1290180336, 2, 'xanax-overdose'),
(5099, 1290180336, 2, 'boom'),
(5100, 1290180336, 2, 'farooq9999'),
(5101, 1290180336, 2, 'berniecuiz'),
(5102, 1290180336, 2, 'LearnBassGuitar'),
(5103, 1290180336, 2, 'ultram-er'),
(5104, 1290180336, 2, 'zyrtec-d'),
(5105, 1290180336, 2, 'nexium-reactions'),
(5106, 1290180336, 2, 'zyrtec-d'),
(5107, 1290180336, 2, 'muscleweighttraining'),
(5108, 1290180336, 2, 'adderall-abuse'),
(5109, 1290180336, 2, 'prescription-drug-ca'),
(5110, 1290180336, 2, 'very-cheap-tramadol'),
(5111, 1290180336, 2, 'order-carisoprodol'),
(5112, 1290180336, 2, 'subaction-showcommen'),
(5113, 1290180336, 2, 'valtrex-vs-acyclovir'),
(5114, 1290180336, 2, 'doxycycline-and-ms'),
(5115, 1290180336, 2, 'singulair-side-effec'),
(5116, 1290180336, 2, 'buy-hydrocodone-mexi'),
(5117, 1290180336, 2, 'free-diet-pill'),
(5118, 1290180336, 2, 'buy-hydrocodone-no-p'),
(5119, 1290180336, 2, 'can-clomid-change-yo'),
(5120, 1290180336, 2, 'vicodin-rehab'),
(5121, 1290180336, 2, 'mahjongg12'),
(5122, 1290180336, 2, 'cozaar-side-effects'),
(5123, 1290180336, 2, 'mikealvares56'),
(5124, 1290180336, 2, 'luciano27erickso'),
(5125, 1290180336, 2, 'balmerd41'),
(5126, 1290180336, 2, 'doctors-who-prescrib'),
(5127, 1290180336, 2, 'susanwarren'),
(5128, 1290180336, 2, 'haroldkenney'),
(5129, 1290180336, 2, 'brilierrabago'),
(5130, 1290180336, 2, 'buspar-for-dogs'),
(5131, 1290180336, 2, 'Jhonny2010'),
(5132, 1290180336, 2, 'dangerous-side-effec'),
(5133, 1290180336, 2, 'effexor-generic'),
(5134, 1290180336, 2, 'buy-alprazolam'),
(5135, 1290180336, 2, 'williams45pennin'),
(5136, 1290180336, 2, 'valium-online'),
(5137, 1290180336, 2, 'coherentoaf0'),
(5138, 1290180336, 2, 'cialis-tadalafil'),
(5139, 1290180336, 2, 'premarin-ingredients'),
(5140, 1290180336, 2, 'phentermine-37.5-low'),
(5141, 1290180336, 2, 'ziyizang'),
(5142, 1290180336, 2, 'mack9turner'),
(5143, 1290180336, 2, 'Syenoh'),
(5144, 1290180336, 2, 'effexor-xr-vouchers'),
(5145, 1290180336, 2, 'prozac-side-effect'),
(5146, 1290180336, 2, 'adipex-dangers'),
(5147, 1290180336, 2, 'purchase-viagra'),
(5148, 1290180336, 2, 'somas'),
(5149, 1290180336, 2, 'cialis-online'),
(5150, 1290180336, 2, 'coledms'),
(5151, 1290180336, 2, 'chart96'),
(5152, 1290180336, 2, 'tangledfanatic01'),
(5153, 1290180336, 2, 'joshua79briggs'),
(5154, 1290180336, 2, 'joshua75briggs'),
(5155, 1290180336, 2, 'craig4padilla'),
(5156, 1290180336, 2, 'capricecap99'),
(5157, 1290180336, 2, 'vomitnomore'),
(5158, 1290180336, 2, 'haltonjames'),
(5159, 1290180336, 2, 'metalbunk55b'),
(5160, 1290180336, 2, 'bolingerjohn'),
(5161, 1290180336, 2, 'Wohld635'),
(5162, 1290180336, 2, 'phones4you11'),
(5163, 1290180336, 2, 'mpb4today11'),
(5164, 1290180336, 2, 'JanelleLaney749'),
(5165, 1290180336, 2, 'darwin34potter'),
(5166, 1290180336, 2, 'Excectfet'),
(5167, 1290180336, 2, 'NSozie'),
(5168, 1290180336, 2, 'warren89whitney'),
(5169, 1290180336, 2, 'burt38whitley'),
(5170, 1290180336, 2, 'CKjacquetta'),
(5171, 1290180336, 2, 'AndoStyle'),
(5172, 1290180336, 2, 'Kelseyzarat'),
(5173, 1290180336, 2, 'alvin6fowler'),
(5174, 1290180336, 2, 'kkarenschock'),
(5175, 1290180336, 2, 'phillisrocawr388'),
(5176, 1290180336, 2, 'tetryhorne123'),
(5177, 1290180336, 2, 'QDalec'),
(5178, 1290180336, 2, 'leadmachine'),
(5179, 1290180336, 2, 'bradley6christen'),
(5180, 1290180336, 2, 'Bricklnoes'),
(5181, 1290180336, 2, 'cancasa'),
(5182, 1290180336, 2, 'cll0228'),
(5183, 1290180336, 2, 'CJheights'),
(5184, 1290180336, 2, 'DrCHampton'),
(5185, 1290180336, 2, 'baby201008'),
(5186, 1290180336, 2, 'danorlando95'),
(5187, 1290180336, 2, 'JimmyHanrdfgh'),
(5188, 1290180336, 2, 'gangwell'),
(5189, 1290180336, 2, 'tanglediwatch02'),
(5190, 1290180336, 2, 'onlinekl'),
(5191, 1290180336, 2, 'mikeevans412'),
(5192, 1290180336, 2, 'LPNjobdescription2010'),
(5193, 1290180336, 2, 'hmeighan65'),
(5194, 1290180336, 2, 'fancases'),
(5195, 1290180336, 2, 'chiropracticphysician3'),
(5196, 1290180336, 2, 'ARABELLA'),
(5197, 1290180336, 2, 'billynaismith'),
(5198, 1290180336, 2, 'intel45'),
(5199, 1290180336, 2, 'archie57hunter'),
(5200, 1290180336, 2, 'blackpool5hotels'),
(5201, 1290180336, 2, 'stereotypical'),
(5202, 1290180336, 2, 'NifontQa'),
(5203, 1290180336, 2, 'ZRjackqueline'),
(5204, 1290180336, 2, 'justingrave24'),
(5205, 1290180336, 2, 'christophrw28'),
(5206, 1290180336, 2, 'Fatimah'),
(5207, 1290180336, 2, 'timmkack'),
(5208, 1290180336, 2, 'CroCop'),
(5209, 1290180336, 2, 'LXchia'),
(5210, 1290180336, 2, 'argothian'),
(5211, 1290180336, 2, 'clerinsmadona'),
(5212, 1290180336, 2, 'RexSimon18'),
(5213, 1290180336, 2, 'peter8moreno'),
(5214, 1290180336, 2, 'nygydk'),
(5215, 1290180336, 2, 'loetz'),
(5216, 1290180336, 2, 'domainhost'),
(5217, 1290180336, 2, 'disguyjohnson'),
(5218, 1290180336, 2, 'redazemautted'),
(5219, 1290180336, 2, 'BLjackelyn'),
(5220, 1290180336, 2, 'nellyflopb'),
(5221, 1290180336, 2, 'XDhector'),
(5222, 1290180336, 2, 'Zenwaitlyimmaw'),
(5223, 1290180336, 2, 'insidlide'),
(5224, 1290180336, 2, 'homeandbeds'),
(5225, 1290180336, 2, 'bhphcarguy9696'),
(5226, 1290180336, 2, 'kent23hagorerson'),
(5227, 1290180336, 2, 'Bootdaurrouct'),
(5228, 1290180336, 2, 'ATedda'),
(5229, 1290180336, 2, 'danial66fuller'),
(5230, 1290180336, 2, 'aa33030'),
(5231, 1290180336, 2, 'EVgwenda'),
(5232, 1290180336, 2, 'sterling6412hutchi'),
(5233, 1290180336, 2, 'Doobiargo'),
(5234, 1290180336, 2, 'Mabenbkaoe'),
(5235, 1290180336, 2, 'W.Trautenberg'),
(5236, 1290180336, 2, 'Nora.Karegyan'),
(5237, 1290180336, 2, 'vinensia'),
(5238, 1290180336, 2, 'stokesbarbara594'),
(5239, 1290180336, 2, 'parisfrancia'),
(5240, 1290180336, 2, 'ginebra'),
(5241, 1290180336, 2, 'alva7mckinpar'),
(5242, 1290180336, 2, 'deluxgoodnew'),
(5243, 1290180336, 2, 'HOsid'),
(5244, 1290180336, 2, 'Mariathomas'),
(5245, 1290180336, 2, 'lht192'),
(5246, 1290180336, 2, 'basil731'),
(5247, 1290180336, 2, 'domainhost'),
(5248, 1290180336, 2, 'philiple'),
(5249, 1290180336, 2, 'Akilar123'),
(5250, 1290180336, 2, 'kennrner7'),
(5251, 1290180336, 2, 'mervine49nielsen'),
(5252, 1290180336, 2, 'smithira21'),
(5253, 1290180336, 2, 'SheidlerGilbert184'),
(5254, 1290180336, 2, 'OutlawLover'),
(5255, 1290180336, 2, 'nephira19'),
(5256, 1290180336, 2, 'mwayne01'),
(5257, 1290180336, 2, 'johnmakarenko'),
(5258, 1290180336, 2, 'AddieT83'),
(5259, 1290180336, 2, 'lucievfedrrikts'),
(5260, 1290180336, 2, 'pinestip'),
(5261, 1290180336, 2, 'markingram6'),
(5262, 1290180336, 2, 'guideline'),
(5263, 1290180336, 2, 'GloomilyFragile'),
(5264, 1290180336, 2, 'CVvannesa'),
(5265, 1290180336, 2, 'krishna'),
(5266, 1290180336, 2, 'dragon88'),
(5267, 1290180336, 2, 'johnkyth'),
(5268, 1290180336, 2, 'usman201008'),
(5269, 1290180336, 2, 'excelhelp'),
(5270, 1290180336, 2, 'dreamdancer'),
(5271, 1290180336, 2, 'Bernetta'),
(5272, 1290180336, 2, 'MoikeZetMeafe'),
(5273, 1290180336, 2, 'weightlossboxx'),
(5274, 1290180336, 2, 'firstlalimo'),
(5275, 1290180336, 2, 'stewart66owens'),
(5276, 1290180336, 2, 'Oathkeeper'),
(5277, 1290180336, 2, 'computergeekspeed'),
(5278, 1290180336, 2, 'debtrelief123'),
(5279, 1290180336, 2, 'LikeMyShare'),
(5280, 1290180336, 2, 'djohnson906'),
(5281, 1290180336, 2, 'salesmlm12'),
(5282, 1290180336, 2, 'QQtanisha'),
(5283, 1290180336, 2, 'trastrap'),
(5284, 1290180336, 2, 'satellite12'),
(5285, 1290180336, 2, 'soveMigovoppy'),
(5286, 1290180336, 2, 'roke'),
(5287, 1290180336, 2, 'satellite12'),
(5288, 1290180336, 2, 'Zaznqaakl'),
(5289, 1290180336, 2, 'Gaus Rafi'),
(5290, 1290180336, 2, 'devlega985'),
(5291, 1290180336, 2, 'hundun'),
(5292, 1290180336, 2, 'richardsuryajaya'),
(5293, 1290180336, 2, 'uniformmeet'),
(5294, 1290180336, 2, 'BLrefugio'),
(5295, 1290180336, 2, 'Magimmuxugh'),
(5296, 1290180336, 2, 'nolan19bray'),
(5297, 1290180336, 2, 'hosting'),
(5298, 1290180336, 2, 'Pemorargo'),
(5299, 1290180336, 2, 'bhuvana'),
(5300, 1290180336, 2, 'fashion2k10pro'),
(5301, 1290180336, 2, 'srdjananderson5269'),
(5302, 1290180336, 2, 'swankybarrel53'),
(5303, 1290180336, 2, 'smithed1982'),
(5304, 1290180336, 2, 'Insernifari'),
(5305, 1290180336, 2, 'noithuy123'),
(5306, 1290180336, 2, 'chadchau13'),
(5307, 1290180336, 2, 'historicalspect'),
(5308, 1290180336, 2, 'goodmanupstairs'),
(5309, 1290180336, 2, 'liaillenlarve'),
(5310, 1290180336, 2, 'WZgarnett'),
(5311, 1290180336, 2, 'Gaus Rafi'),
(5312, 1290180336, 2, 'damac012'),
(5313, 1290180336, 2, 'oldfroglet'),
(5314, 1290180336, 2, 'glacegrafix'),
(5315, 1290180336, 2, 'clickhall1957'),
(5316, 1290180336, 2, 'saul4pearson'),
(5317, 1290180336, 2, 'cheapkamagra'),
(5318, 1290180336, 2, 'CEbrooks'),
(5319, 1290180336, 2, 'bestonlinebetfree'),
(5320, 1290180336, 2, 'mel44wyat'),
(5321, 1290180336, 2, 'wetooelj82'),
(5322, 1290180336, 2, '11x17_binders'),
(5323, 1290180336, 2, 'OBkerri'),
(5324, 1290180336, 2, 'implanturicardiace'),
(5325, 1290180336, 2, 'mooncake123'),
(5326, 1290180336, 2, 'JWathena'),
(5327, 1290180336, 2, 'adrtech'),
(5328, 1290180336, 2, 'jordonlikins'),
(5329, 1290180336, 2, 'coltchicken'),
(5330, 1290180336, 2, 'hostingreviewworld'),
(5331, 1290180336, 2, 'benante'),
(5332, 1290180336, 2, 'tommie58hicks'),
(5333, 1290180336, 2, 'ZBmaura'),
(5334, 1290180336, 2, 'pa1111'),
(5335, 1290180336, 2, 'Enetecavytymn'),
(5336, 1290180336, 2, 'shirtsxxl'),
(5337, 1290180336, 2, 'permondinix'),
(5338, 1290180336, 2, 'Linaish'),
(5339, 1290180336, 2, 'addetaite'),
(5340, 1290180336, 2, 'GJludivina'),
(5341, 1290180336, 2, 'thompson44'),
(5342, 1290180336, 2, 'booker78clark'),
(5343, 1290180336, 2, 'desmond38duncan'),
(5344, 1290180336, 2, 'vernongetzler'),
(5345, 1290180336, 2, 'israeler9roth'),
(5346, 1290180336, 2, 'aldoy29'),
(5347, 1290180336, 2, 'tristian216516'),
(5348, 1290180336, 2, 'somantos'),
(5349, 1290180336, 2, 'onyszkou'),
(5350, 1290180336, 2, 'jasonred0118'),
(5351, 1290180336, 2, 'FrancisTZ'),
(5352, 1290180336, 2, 'jansenm23'),
(5353, 1290180336, 2, 'jasonred0118'),
(5354, 1290180336, 2, 'Yardy133'),
(5355, 1290180336, 2, 'freeindia33'),
(5356, 1290180336, 2, 'marriage_guru'),
(5357, 1290180336, 2, 'wordgames'),
(5358, 1290180336, 2, 'TenderZephyr'),
(5359, 1290180336, 2, 'minxzas1412'),
(5360, 1290180336, 2, 'grover98sharp'),
(5361, 1290180336, 2, 'todd83cannon'),
(5362, 1290180336, 2, 'kjnoonsfan12'),
(5363, 1290180336, 2, 'atticfan911'),
(5364, 1290180336, 2, 'julianmarble'),
(5365, 1290180336, 2, 'lord25078mejia'),
(5366, 1290180336, 2, 'Thiesse.Glen510'),
(5367, 1290180336, 2, 'dailyhacking'),
(5368, 1290180336, 2, 'swolf1976s'),
(5369, 1290180336, 2, 'hophip820'),
(5370, 1290180336, 2, 'Anson99'),
(5371, 1290180336, 2, 'hhealth0102'),
(5372, 1290180336, 2, 'onlinebingo'),
(5373, 1290180336, 2, 'merriman72'),
(5374, 1290180336, 2, 'wilmer69mooney'),
(5375, 1290180336, 2, 'McleanDowel'),
(5376, 1290180336, 2, 'suzzyroy'),
(5377, 1290180336, 2, 'kajadmarist'),
(5378, 1290180336, 2, 'isidro94leach'),
(5379, 1290180336, 2, 'brooks9douglas'),
(5380, 1290180336, 2, 'bobbie55allen'),
(5381, 1290180336, 2, 'MarionMcleodYU'),
(5382, 1290180336, 2, 'shadeplelay'),
(5383, 1290180336, 2, 'mitchelljohntion'),
(5384, 1290180336, 2, 'hoIlla1975'),
(5385, 1290180336, 2, 'summerkathy86'),
(5386, 1290180336, 2, 'dayattendant4'),
(5387, 1290180336, 2, 'Slar245'),
(5388, 1290180336, 2, 'parsonsmax26'),
(5389, 1290180336, 2, 'Insurance111'),
(5390, 1290180336, 2, 'njweb86design'),
(5391, 1290180336, 2, 'glutenfree'),
(5392, 1290180336, 2, 'mattharris1'),
(5393, 1290180336, 2, 'gamesplayer24'),
(5394, 1290180336, 2, 'jess86impotencefuller'),
(5395, 1290180336, 2, 'joomlavideo'),
(5396, 1290180336, 2, 'winstonjrudd'),
(5397, 1290180336, 2, 'prestonuxwall'),
(5398, 1290180336, 2, 'oliviyaoliver'),
(5399, 1290180336, 2, 'christinamadisonc2000'),
(5400, 1290180336, 2, 'bryon4joyce'),
(5401, 1290180336, 2, 'gorylek2'),
(5402, 1290180336, 2, 'EnergyDeregulation13'),
(5403, 1290180336, 2, 'cigu'),
(5404, 1290180336, 2, 'Helalashata786@gmail.com'),
(5405, 1290180336, 2, 'hugo93banks'),
(5406, 1290180336, 2, 'postalannex76'),
(5407, 1290180336, 2, 'thomasjj22'),
(5408, 1290180336, 2, 'modeling12'),
(5409, 1290180336, 2, 'caizhengyi'),
(5410, 1290180336, 2, 'jack400simon'),
(5411, 1290180336, 2, 'jun2monitorzore'),
(5412, 1290180336, 2, 'sacramentointer'),
(5413, 1290180336, 2, 'hispower'),
(5414, 1290180336, 2, 'kaiya123'),
(5415, 1290180336, 2, 'VeronicaDan123'),
(5416, 1290180467, 3, '202.51.185.12'),
(5417, 1290180467, 3, '189.26.135.225'),
(5418, 1290180467, 3, '203.92.52.134'),
(5419, 1290180467, 3, '83.24.245.29'),
(5420, 1290180467, 3, '122.168.47.138'),
(5421, 1290180467, 3, '112.202.3.79'),
(5422, 1290180467, 3, '123.27.104.115'),
(5423, 1290180467, 3, '114.235.121.135'),
(5424, 1290180467, 3, '203.100.74.187'),
(5425, 1290180467, 3, '59.96.91.69'),
(5426, 1290180467, 3, '95.26.52.73'),
(5427, 1290180467, 3, '123.17.176.149'),
(5428, 1290180467, 3, '117.241.97.40'),
(5429, 1290180467, 3, '117.192.4.148'),
(5430, 1290180467, 3, '94.200.40.2'),
(5431, 1290180467, 3, '75.127.165.220'),
(5432, 1290180467, 3, '120.28.213.212'),
(5433, 1290180467, 3, '74.115.209.59'),
(5434, 1290180467, 3, '110.55.166.107'),
(5435, 1290180467, 3, '89.252.39.170'),
(5436, 1290180467, 3, '71.131.0.123'),
(5437, 1290180467, 3, '173.234.175.193'),
(5438, 1290180467, 3, '173.234.158.239'),
(5439, 1290180467, 3, '60.25.161.100'),
(5440, 1290180467, 3, '122.163.232.41'),
(5441, 1290180467, 3, '76.67.179.27'),
(5442, 1290180467, 3, '213.143.72.88'),
(5443, 1290180467, 3, '93.208.182.60'),
(5444, 1290180467, 3, '117.196.224.30'),
(5445, 1290180467, 3, '115.132.78.26'),
(5446, 1290180467, 3, '66.90.104.167'),
(5447, 1290180467, 3, '80.222.47.166'),
(5448, 1290180467, 3, '86.46.144.222'),
(5449, 1290180467, 3, '115.87.136.135'),
(5450, 1290180467, 3, '122.174.108.121'),
(5451, 1290180467, 3, '122.168.221.89'),
(5452, 1290180467, 3, '117.200.179.26'),
(5453, 1290180467, 3, '118.160.27.146'),
(5454, 1290180467, 3, '115.72.234.245'),
(5455, 1290180467, 3, '124.73.100.248'),
(5456, 1290180467, 3, '173.234.48.225'),
(5457, 1290180467, 3, '78.177.185.123'),
(5458, 1290180467, 3, '74.211.83.211'),
(5459, 1290180467, 3, '85.180.87.77'),
(5460, 1290180467, 3, '93.177.146.162'),
(5461, 1290180467, 3, '78.33.94.44'),
(5462, 1290180467, 3, '119.153.70.59'),
(5463, 1290180467, 3, '115.87.181.29'),
(5464, 1290180467, 3, '115.133.32.124'),
(5465, 1290180467, 3, '72.148.219.74'),
(5466, 1290180467, 3, '59.161.136.106'),
(5467, 1290180467, 3, '38.113.161.250'),
(5468, 1290180467, 3, '94.240.209.56'),
(5469, 1290180467, 3, '120.28.251.229'),
(5470, 1290180467, 3, '59.161.89.200'),
(5471, 1290180467, 3, '92.23.23.70'),
(5472, 1290180467, 3, '122.168.171.212'),
(5473, 1290180467, 3, '117.199.117.0'),
(5474, 1290180467, 3, '122.163.216.186'),
(5475, 1290180467, 3, '117.193.148.254'),
(5476, 1290180467, 3, '112.198.245.117'),
(5477, 1290180467, 3, '117.200.179.15'),
(5478, 1290180467, 3, '109.122.17.215'),
(5479, 1290180467, 3, '117.200.179.128'),
(5480, 1290180467, 3, '69.22.184.8'),
(5481, 1290180467, 3, '117.196.138.253'),
(5482, 1290180467, 3, '122.178.153.127'),
(5483, 1290180467, 3, '120.28.252.47'),
(5484, 1290180467, 3, '72.161.108.28'),
(5485, 1290180467, 3, '91.61.184.23'),
(5486, 1290180467, 3, '87.254.149.183'),
(5487, 1290180467, 3, '216.146.138.171'),
(5488, 1290180467, 3, '78.106.114.136'),
(5489, 1290180467, 3, '202.177.241.176'),
(5490, 1290180467, 3, '203.92.52.154'),
(5491, 1290180467, 3, '94.120.223.130'),
(5492, 1290180467, 3, '173.208.70.20'),
(5493, 1290180467, 3, '78.143.213.227'),
(5494, 1290180467, 3, '59.180.18.193'),
(5495, 1290180467, 3, '180.234.17.4'),
(5496, 1290180467, 3, '178.3.171.84'),
(5497, 1290180467, 3, '202.177.241.229'),
(5498, 1290180467, 3, '218.81.88.114'),
(5499, 1290180467, 3, '117.200.176.188'),
(5500, 1290180467, 3, '125.24.0.233'),
(5501, 1290180467, 3, '203.99.172.40'),
(5502, 1290180467, 3, '83.170.106.211'),
(5503, 1290180467, 3, '92.48.93.242'),
(5504, 1290180467, 3, '173.234.233.100'),
(5505, 1290180467, 3, '117.242.224.154'),
(5506, 1290180467, 3, '112.200.42.237'),
(5507, 1290180467, 3, '117.196.234.124'),
(5508, 1290180467, 3, '69.163.39.238'),
(5509, 1290180467, 3, '117.242.224.207'),
(5510, 1290180467, 3, '68.225.227.193'),
(5511, 1290180467, 3, '110.55.175.99'),
(5512, 1290180467, 3, '110.55.174.246'),
(5513, 1290180467, 3, '203.92.52.132'),
(5514, 1290180467, 3, '69.179.2.147'),
(5515, 1290180467, 3, '120.28.208.242'),
(5516, 1290180467, 3, '94.120.208.23'),
(5517, 1290180467, 3, '91.205.173.51'),
(5518, 1290180467, 3, '95.48.65.69'),
(5519, 1290180467, 3, '70.75.163.62'),
(5520, 1290180467, 3, '188.221.129.159'),
(5521, 1290180467, 3, '88.242.183.250'),
(5522, 1290180467, 3, '71.131.11.167'),
(5523, 1290180467, 3, '189.164.9.226'),
(5524, 1290180467, 3, '78.151.85.19'),
(5525, 1290180467, 3, '79.160.144.80'),
(5526, 1290180467, 3, '1.23.73.109'),
(5527, 1290180467, 3, '114.93.241.199'),
(5528, 1290180467, 3, '75.218.242.38'),
(5529, 1290180467, 3, '78.148.18.144'),
(5530, 1290180467, 3, '81.192.238.30'),
(5531, 1290180467, 3, '113.167.145.193'),
(5532, 1290180467, 3, '67.215.249.175'),
(5533, 1290180467, 3, '94.120.214.164'),
(5534, 1290180467, 3, '213.107.66.16'),
(5535, 1290180467, 3, '75.3.126.218'),
(5536, 1290180467, 3, '70.75.163.62'),
(5537, 1290180467, 3, '125.24.43.162'),
(5538, 1290180467, 3, '38.109.45.248'),
(5539, 1290180467, 3, '79.119.212.62'),
(5540, 1290180467, 3, '76.230.214.66'),
(5541, 1290180467, 3, '180.190.157.80'),
(5542, 1290180467, 3, '88.169.248.123'),
(5543, 1290180467, 3, '117.200.186.156'),
(5544, 1290180467, 3, '213.107.66.16'),
(5545, 1290180467, 3, '75.127.105.183'),
(5546, 1290180467, 3, '203.92.52.143'),
(5547, 1290180467, 3, '58.27.171.132'),
(5548, 1290180467, 3, '112.135.31.158'),
(5549, 1290180467, 3, '77.180.12.245'),
(5550, 1290180467, 3, '122.163.78.8'),
(5551, 1290180467, 3, '113.168.247.202'),
(5552, 1290180467, 3, '95.176.149.255'),
(5553, 1290180467, 3, '68.225.227.193'),
(5554, 1290180467, 3, '71.131.0.123'),
(5555, 1290180467, 3, '173.234.119.138'),
(5556, 1290180467, 3, '60.50.102.179'),
(5557, 1290180467, 3, '119.92.79.50'),
(5558, 1290180467, 3, '99.28.91.177'),
(5559, 1290180467, 3, '121.96.38.34'),
(5560, 1290180467, 3, '180.190.180.82'),
(5561, 1290180467, 3, '117.242.224.109'),
(5562, 1290180467, 3, '98.165.162.117'),
(5563, 1290180467, 3, '122.175.91.172'),
(5564, 1290180467, 3, '173.234.153.29'),
(5565, 1290180467, 3, '180.234.28.247'),
(5566, 1290180467, 3, '206.217.219.14'),
(5567, 1290180467, 3, '120.28.250.203'),
(5568, 1290180467, 3, '156.34.78.144'),
(5569, 1290180467, 3, '213.0.89.11'),
(5570, 1290180467, 3, '156.34.78.144'),
(5571, 1290180467, 3, '83.4.225.64'),
(5572, 1290180467, 3, '180.234.32.67'),
(5573, 1290180467, 3, '125.24.38.121'),
(5574, 1290180467, 3, '89.253.128.102'),
(5575, 1290180467, 3, '91.32.212.72'),
(5576, 1290180467, 3, '209.107.204.13'),
(5577, 1290180467, 3, '76.114.145.53'),
(5578, 1290180467, 3, '187.146.62.242'),
(5579, 1290180467, 3, '98.142.219.17'),
(5580, 1290180467, 3, '110.159.155.128'),
(5581, 1290180467, 3, '122.162.17.42'),
(5582, 1290180467, 3, '117.6.72.34'),
(5583, 1290180467, 3, '117.242.224.129'),
(5584, 1290180467, 3, '110.55.171.175'),
(5585, 1290180467, 3, '112.201.246.156'),
(5586, 1290180467, 3, '98.148.154.7'),
(5587, 1290180467, 3, '112.202.103.32'),
(5588, 1290180467, 3, '212.117.183.163'),
(5589, 1290180467, 3, '86.161.145.244'),
(5590, 1290180467, 3, '24.250.135.231'),
(5591, 1290180467, 3, '125.162.15.139'),
(5592, 1290180467, 3, '77.99.40.119'),
(5593, 1290180467, 3, '173.234.176.116'),
(5594, 1290180467, 3, '66.220.30.122'),
(5595, 1290180467, 3, '173.208.40.38'),
(5596, 1290180467, 3, '94.5.1.21'),
(5597, 1290180467, 3, '98.70.132.216'),
(5598, 1290180467, 3, '71.184.242.198'),
(5599, 1290180467, 3, '86.11.201.181'),
(5600, 1290180467, 3, '94.193.172.107'),
(5601, 1290180467, 3, '124.6.181.108'),
(5602, 1290180467, 3, '124.105.57.152'),
(5603, 1290180467, 3, '86.183.182.34'),
(5604, 1290180467, 3, '119.180.145.165'),
(5605, 1290180467, 3, '87.194.141.220'),
(5606, 1290180467, 3, '94.209.124.226'),
(5607, 1290180467, 3, '88.234.163.191'),
(5608, 1290180467, 3, '206.217.219.21'),
(5609, 1290180467, 3, '120.28.206.192'),
(5610, 1290180467, 3, '90.212.212.31'),
(5611, 1290180467, 3, '173.234.48.225'),
(5612, 1290180467, 3, '58.166.109.217'),
(5613, 1290180467, 3, '117.2.15.83'),
(5614, 1290180467, 3, '58.27.150.20'),
(5615, 1290180467, 3, '95.143.208.118'),
(5616, 1290180467, 3, '80.225.57.105'),
(5617, 1290180467, 3, '112.205.59.104'),
(5618, 1290180467, 3, '122.168.59.145'),
(5619, 1290180467, 3, '70.191.189.10'),
(5620, 1290180467, 3, '212.66.42.134'),
(5621, 1290180467, 3, '59.92.20.86'),
(5622, 1290180467, 3, '112.198.240.86'),
(5623, 1290180467, 3, '119.153.45.21'),
(5624, 1290180467, 3, '75.119.229.64'),
(5625, 1290180467, 3, '76.232.67.134'),
(5626, 1290180467, 3, '180.190.181.125'),
(5627, 1290180467, 3, '122.172.4.64'),
(5628, 1290180467, 3, '174.121.79.172'),
(5629, 1290180467, 3, '116.193.173.1'),
(5630, 1290180467, 3, '117.242.224.175'),
(5631, 1290180467, 3, '83.113.220.92'),
(5632, 1290180467, 3, '110.139.72.55'),
(5633, 1290180467, 3, '95.148.25.186'),
(5634, 1290180467, 3, '114.108.86.131'),
(5635, 1290180467, 3, '74.115.209.34'),
(5636, 1290180467, 3, '99.230.210.101'),
(5637, 1290180467, 3, '174.114.4.117'),
(5638, 1290180467, 3, '174.114.4.117'),
(5639, 1290180467, 3, '174.114.4.117'),
(5640, 1290180467, 3, '117.242.224.192'),
(5641, 1290180467, 3, '174.114.4.117'),
(5642, 1290180467, 3, '98.169.130.235'),
(5643, 1290180467, 3, '112.202.101.32'),
(5644, 1290180467, 3, '222.155.35.80'),
(5645, 1290180467, 3, '124.43.11.48'),
(5646, 1290180467, 3, '195.137.11.103'),
(5647, 1290180467, 3, '97.121.187.178'),
(5648, 1290180467, 3, '98.17.101.180'),
(5649, 1290180467, 3, '68.104.180.236'),
(5650, 1290180467, 3, '221.206.102.225'),
(5651, 1290180467, 3, '41.250.106.41'),
(5652, 1290180467, 3, '184.99.186.20'),
(5653, 1290180467, 3, '98.111.129.180'),
(5654, 1290180467, 3, '180.245.252.60'),
(5655, 1290180467, 3, '74.61.31.182'),
(5656, 1290180467, 3, '64.120.51.218'),
(5657, 1290180467, 3, '76.232.64.221'),
(5658, 1290180467, 3, '75.102.39.207'),
(5659, 1290180467, 3, '112.198.216.208'),
(5660, 1290180467, 3, '71.49.207.25'),
(5661, 1290180467, 3, '89.123.106.144'),
(5662, 1290180467, 3, '209.222.133.190'),
(5663, 1290180467, 3, '94.75.233.7'),
(5664, 1290180467, 3, '173.208.77.53'),
(5665, 1290180467, 3, '24.8.143.73'),
(5666, 1290180467, 3, '112.203.196.68'),
(5667, 1290180467, 3, '198.70.218.83'),
(5668, 1290180467, 3, '24.45.195.115'),
(5669, 1290180467, 3, '62.241.69.228'),
(5670, 1290180467, 3, '212.84.124.233'),
(5671, 1290180467, 3, '84.61.149.122'),
(5672, 1290180467, 3, '216.66.59.42'),
(5673, 1290180467, 3, '209.165.254.135'),
(5674, 1290180467, 3, '74.89.100.20'),
(5675, 1290180467, 3, '71.170.99.58'),
(5676, 1290180467, 3, '83.21.11.207'),
(5677, 1290180467, 3, '117.241.80.193'),
(5678, 1290180467, 3, '193.238.215.184'),
(5679, 1290180467, 3, '109.123.99.38'),
(5680, 1290180467, 3, '125.26.83.6'),
(5681, 1290180467, 3, '119.155.5.133'),
(5682, 1290180467, 3, '94.240.40.62'),
(5683, 1290180467, 3, '209.222.8.187'),
(5684, 1290180467, 3, '41.250.111.126'),
(5685, 1290180467, 3, '112.202.78.32'),
(5686, 1290180467, 3, '118.137.93.242'),
(5687, 1290180467, 3, '89.123.97.245'),
(5688, 1290180467, 3, '122.49.210.50'),
(5689, 1290180467, 3, '203.213.6.220'),
(5690, 1290180467, 3, '92.40.221.44'),
(5691, 1290180467, 3, '78.146.228.33'),
(5692, 1290180467, 3, '59.164.108.176'),
(5693, 1290180467, 3, '116.71.32.225'),
(5694, 1290180467, 3, '72.20.18.211'),
(5695, 1290180467, 3, '93.103.55.111'),
(5696, 1290180467, 3, '180.178.144.99'),
(5697, 1290180467, 3, '119.94.200.142'),
(5698, 1290180467, 3, '69.179.75.204'),
(5699, 1290180467, 3, '123.238.116.168'),
(5700, 1290180467, 3, '113.162.87.250'),
(5701, 1290180467, 3, '91.32.240.243'),
(5702, 1290180467, 3, '124.171.35.102'),
(5703, 1290180467, 3, '219.134.64.253'),
(5704, 1290180467, 3, '88.234.41.49'),
(5705, 1290180467, 3, '118.70.117.12'),
(5706, 1290180467, 3, '68.168.215.67'),
(5707, 1290180467, 3, '97.121.186.137'),
(5708, 1290180467, 3, '110.55.246.116'),
(5709, 1290180467, 3, '71.202.249.117'),
(5710, 1290180467, 3, '71.131.20.82'),
(5711, 1290180467, 3, '216.66.59.48'),
(5712, 1290180467, 3, '187.56.178.143'),
(5713, 1290180467, 3, '124.253.45.142'),
(5714, 1290180467, 3, '119.155.1.86'),
(5715, 1290180467, 3, '74.243.42.122'),
(5716, 1290180467, 3, '74.115.212.53'),
(5717, 1290180467, 3, '79.178.45.30'),
(5718, 1290180467, 3, '173.234.19.216'),
(5719, 1290180467, 3, '113.168.253.247'),
(5720, 1290180467, 3, '75.62.207.169'),
(5721, 1290180467, 3, '83.49.186.169'),
(5722, 1290180467, 3, '79.114.251.152'),
(5723, 1290180467, 3, '125.162.236.166'),
(5724, 1290180467, 3, '122.167.100.127'),
(5725, 1290180467, 3, '68.168.217.30'),
(5726, 1290180467, 3, '58.27.155.24'),
(5727, 1290180467, 3, '75.217.227.14'),
(5728, 1290180467, 3, '202.70.59.188'),
(5729, 1290180467, 3, '122.161.67.167'),
(5730, 1290180467, 3, '78.177.205.80'),
(5731, 1290180467, 3, '72.172.109.196'),
(5732, 1290180467, 3, '109.91.146.1'),
(5733, 1290180467, 3, '119.73.42.160'),
(5734, 1290180467, 3, '180.190.149.164'),
(5735, 1290180467, 3, '75.85.182.89'),
(5736, 1290180467, 3, '109.96.122.66'),
(5737, 1290180467, 3, '75.85.182.89'),
(5738, 1290180467, 3, '81.245.73.142'),
(5739, 1290180467, 3, '80.123.47.122'),
(5740, 1290180467, 3, '118.96.172.34'),
(5741, 1290180467, 3, '112.202.56.48'),
(5742, 1290180467, 3, '188.25.70.172'),
(5743, 1290180467, 3, '98.64.225.113'),
(5744, 1290180467, 3, '91.212.226.41'),
(5745, 1290180467, 3, '217.23.11.91'),
(5746, 1290180467, 3, '213.5.64.179'),
(5747, 1290180467, 3, '83.9.114.74'),
(5748, 1290180467, 3, '91.216.122.47'),
(5749, 1290180467, 3, '91.201.66.85'),
(5750, 1290180467, 3, '84.110.249.235'),
(5751, 1290180467, 3, '91.212.226.41'),
(5752, 1290180467, 3, '196.216.68.42'),
(5753, 1290180467, 3, '213.5.70.211'),
(5754, 1290180467, 3, '91.216.122.47'),
(5755, 1290180467, 3, '91.212.226.41'),
(5756, 1290180467, 3, '217.23.11.91'),
(5757, 1290180467, 3, '91.212.226.41'),
(5758, 1290180467, 3, '88.112.215.229'),
(5759, 1290180467, 3, '91.212.226.41'),
(5760, 1290180467, 3, '71.56.4.233'),
(5761, 1290180467, 3, '88.198.23.37'),
(5762, 1290180467, 3, '213.47.194.91'),
(5763, 1290180467, 3, '91.212.226.41'),
(5764, 1290180467, 3, '83.25.44.162'),
(5765, 1290180467, 3, '193.105.210.162'),
(5766, 1290180467, 3, '178.123.30.90'),
(5767, 1290180467, 3, '114.93.232.224'),
(5768, 1290180467, 3, '200.37.226.92'),
(5769, 1290180467, 3, '122.162.254.109'),
(5770, 1290180467, 3, '119.73.33.185'),
(5771, 1290180467, 3, '220.237.153.225'),
(5772, 1290180467, 3, '84.50.164.208'),
(5773, 1290180467, 3, '125.237.40.212'),
(5774, 1290180467, 3, '86.153.233.229'),
(5775, 1290180467, 3, '117.199.192.111'),
(5776, 1290180467, 3, '122.161.122.106'),
(5777, 1290180467, 3, '58.27.170.30'),
(5778, 1290180467, 3, '75.121.192.104'),
(5779, 1290180467, 3, '123.27.109.226'),
(5780, 1290180467, 3, '98.233.32.165'),
(5781, 1290180467, 3, '202.70.59.195'),
(5782, 1290180467, 3, '41.237.212.157'),
(5783, 1290180467, 3, '71.49.204.14'),
(5784, 1290180467, 3, '189.131.169.148'),
(5785, 1290180467, 3, '112.206.142.128'),
(5786, 1290180467, 3, '99.101.230.96'),
(5787, 1290180467, 3, '117.199.22.125'),
(5788, 1290180467, 3, '124.157.153.8'),
(5789, 1290180467, 3, '89.222.234.5'),
(5790, 1290180467, 3, '115.49.162.110'),
(5791, 1290180467, 3, '203.166.207.28'),
(5792, 1290180467, 3, '173.234.48.227'),
(5793, 1290180467, 3, '70.173.146.87'),
(5794, 1290180467, 3, '95.144.79.2'),
(5795, 1290180467, 3, '90.170.120.214'),
(5796, 1290180467, 3, '72.161.118.71'),
(5797, 1290180467, 3, '216.155.158.187'),
(5798, 1290180467, 3, '96.225.228.87'),
(5799, 1290180467, 3, '110.159.130.90'),
(5800, 1290180467, 3, '24.1.115.190'),
(5801, 1290180467, 3, '110.159.135.217'),
(5802, 1290180467, 3, '109.96.93.215'),
(5803, 1290180467, 3, '98.158.124.39'),
(5804, 1290180467, 3, '93.41.197.133'),
(5805, 1290180467, 3, '121.1.11.84'),
(5806, 1290180467, 3, '61.94.143.144'),
(5807, 1290180467, 3, '70.79.139.239'),
(5808, 1290180467, 3, '118.71.181.42'),
(5809, 1290180467, 3, '88.226.142.26'),
(5810, 1290180467, 3, '118.100.205.126'),
(5811, 1290180467, 3, '119.236.111.206'),
(5812, 1290180467, 3, '125.164.134.173'),
(5813, 1290180467, 3, '83.183.143.133'),
(5814, 1290180467, 3, '67.230.167.10'),
(5815, 1290180467, 3, '89.123.106.213'),
(5816, 1290180467, 3, '119.30.38.39'),
(5817, 1290180467, 3, '62.80.220.125'),
(5818, 1290180467, 3, '112.201.12.130'),
(5819, 1290180467, 3, '180.190.149.5'),
(5820, 1290180467, 3, '112.207.139.86'),
(5821, 1290180467, 3, '91.106.122.210'),
(5822, 1290180467, 3, '41.250.114.68'),
(5823, 1290180467, 3, '79.114.251.170'),
(5824, 1290180467, 3, '117.2.15.83'),
(5825, 1290180467, 3, '122.52.149.67'),
(5826, 1290180467, 3, '112.200.74.86'),
(5827, 1290180467, 3, '212.97.10.79'),
(5828, 1290180467, 3, '95.91.146.161'),
(5829, 1290180467, 3, '122.163.183.112'),
(5830, 1290180467, 3, '117.242.224.104'),
(5831, 1290180467, 3, '120.28.226.76'),
(5832, 1290180467, 3, '58.27.159.165'),
(5833, 1290180467, 3, '202.70.51.232'),
(5834, 1290180467, 3, '112.198.248.27'),
(5835, 1290180467, 3, '86.124.19.11'),
(5836, 1290180467, 3, '72.88.86.70'),
(5837, 1290180467, 3, '83.41.127.59'),
(5838, 1290180467, 3, '74.33.102.176'),
(5839, 1290180467, 3, '201.204.143.66'),
(5840, 1290180467, 3, '79.119.111.207'),
(5841, 1290180467, 3, '113.162.87.188'),
(5842, 1290180467, 3, '97.121.181.54'),
(5843, 1290180467, 3, '121.96.188.192'),
(5844, 1290180467, 3, '86.0.207.201'),
(5845, 1290180467, 3, '184.99.182.14'),
(5846, 1290180467, 3, '75.217.182.219'),
(5847, 1290180467, 3, '82.3.111.249'),
(5848, 1290180467, 3, '121.54.117.243'),
(5849, 1290180467, 3, '41.237.6.73'),
(5850, 1290180467, 3, '93.212.102.189'),
(5851, 1290180467, 3, '82.100.253.218'),
(5852, 1290180467, 3, '68.228.188.58'),
(5853, 1290180467, 3, '115.134.209.75'),
(5854, 1290180467, 3, '24.79.139.81'),
(5855, 1290180467, 3, '110.55.85.169'),
(5856, 1290180467, 3, '69.22.184.9'),
(5857, 1290180467, 3, '41.196.66.117'),
(5858, 1290180467, 3, '120.28.223.223'),
(5859, 1290180467, 3, '74.115.160.191'),
(5860, 1290180467, 3, '75.163.157.160'),
(5861, 1290180467, 3, '119.73.43.228'),
(5862, 1290180467, 3, '117.193.147.213'),
(5863, 1290180467, 3, '108.14.185.248'),
(5864, 1290180467, 3, '89.123.102.106'),
(5865, 1290180467, 3, '59.161.121.136'),
(5866, 1290180467, 3, '203.92.52.139'),
(5867, 1290180467, 3, '72.209.205.192'),
(5868, 1290180467, 3, '209.222.133.185'),
(5869, 1290180467, 3, '76.232.67.134');
INSERT INTO `#__sl_SpamFilter` (`id`, `time`, `type`, `term`) VALUES
(5870, 1290180467, 3, '123.225.70.56'),
(5871, 1290180467, 3, '64.134.234.202'),
(5872, 1290180467, 3, '78.165.15.224'),
(5873, 1290180467, 3, '112.201.74.8'),
(5874, 1290180467, 3, '174.142.98.109'),
(5875, 1290180467, 3, '173.208.97.249'),
(5876, 1290180467, 3, '65.34.124.200'),
(5877, 1290180467, 3, '216.55.165.138'),
(5878, 1290180467, 3, '180.190.200.205'),
(5879, 1290180467, 3, '208.54.90.70'),
(5880, 1290180467, 3, '113.23.27.122'),
(5881, 1290180467, 3, '173.234.49.20'),
(5882, 1290180467, 3, '120.28.207.68'),
(5883, 1290180467, 3, '112.202.96.40'),
(5884, 1290180467, 3, '77.208.32.25'),
(5885, 1290180467, 3, '77.28.144.239'),
(5886, 1290180467, 3, '93.85.60.24'),
(5887, 1290180467, 3, '58.213.59.109'),
(5888, 1290180467, 3, '72.64.251.57'),
(5889, 1290180467, 3, '173.234.152.12'),
(5890, 1290180467, 3, '98.230.138.213'),
(5891, 1290180467, 3, '112.202.70.92'),
(5892, 1290180467, 3, '173.234.119.3'),
(5893, 1290180467, 3, '88.77.178.83'),
(5894, 1290180467, 3, '109.96.71.169'),
(5895, 1290180467, 3, '202.70.59.123'),
(5896, 1290180467, 3, '78.146.236.67'),
(5897, 1290180467, 3, '180.190.148.216'),
(5898, 1290180467, 3, '116.71.57.148'),
(5899, 1290180467, 3, '115.248.180.17'),
(5900, 1290180467, 3, '122.161.71.129'),
(5901, 1290180467, 3, '189.164.32.93'),
(5902, 1290180467, 3, '114.122.202.40'),
(5903, 1290180467, 3, '76.103.227.134'),
(5904, 1290180467, 3, '82.234.123.218'),
(5905, 1290180467, 3, '123.27.105.239'),
(5906, 1290180467, 3, '82.74.92.195'),
(5907, 1290180467, 3, '119.155.100.120'),
(5908, 1290180467, 3, '97.121.191.8'),
(5909, 1290180467, 3, '112.201.115.250'),
(5910, 1290180467, 3, '184.76.171.79'),
(5911, 1290180467, 3, '124.6.181.181'),
(5912, 1290180467, 3, '96.238.142.34'),
(5913, 1290180467, 3, '122.174.79.46'),
(5914, 1290180467, 3, '173.234.27.175'),
(5915, 1290180467, 3, '94.169.9.71'),
(5916, 1290180467, 3, '94.169.9.71'),
(5917, 1290180467, 3, '79.119.178.216'),
(5918, 1290180467, 3, '122.144.101.142'),
(5919, 1290180467, 3, '112.201.190.109'),
(5920, 1290180467, 3, '96.31.87.218'),
(5921, 1290180467, 3, '69.197.15.31'),
(5922, 1290180467, 3, '173.234.48.225'),
(5923, 1290180467, 3, '173.234.45.247'),
(5924, 1290180467, 3, '82.131.117.2'),
(5925, 1290180467, 3, '82.131.59.236'),
(5926, 1290180467, 3, '82.5.186.141'),
(5927, 1290180467, 3, '66.55.136.228'),
(5928, 1290180467, 3, '99.229.146.6'),
(5929, 1290180467, 3, '173.234.175.193'),
(5930, 1290180467, 3, '173.234.119.58'),
(5931, 1290180467, 3, '112.202.120.165'),
(5932, 1290180467, 3, '76.232.66.243'),
(5933, 1290180467, 3, '122.161.222.97'),
(5934, 1290180467, 3, '112.202.1.42'),
(5935, 1290180467, 3, '112.203.115.61'),
(5936, 1290180467, 3, '79.113.122.53'),
(5937, 1290180467, 3, '91.109.110.69'),
(5938, 1290180467, 3, '58.27.152.61'),
(5939, 1290180467, 3, '71.201.155.19'),
(5940, 1290180467, 3, '173.234.157.20'),
(5941, 1290180467, 3, '188.241.113.5'),
(5942, 1290180467, 3, '71.131.11.167'),
(5943, 1290180467, 3, '75.212.236.16'),
(5944, 1290180467, 3, '72.20.49.76'),
(5945, 1290180467, 3, '98.112.228.56'),
(5946, 1290180467, 3, '67.163.70.48'),
(5947, 1290180467, 3, '202.70.59.80'),
(5948, 1290180467, 3, '109.96.102.50'),
(5949, 1290180467, 3, '172.190.2.204'),
(5950, 1290180467, 3, '93.96.210.223'),
(5951, 1290180467, 3, '117.193.141.137'),
(5952, 1290180467, 3, '72.55.139.165'),
(5953, 1290180467, 3, '221.187.149.100'),
(5954, 1290180467, 3, '213.229.88.210'),
(5955, 1290180467, 3, '205.209.140.198'),
(5956, 1290180467, 3, '121.96.169.10'),
(5957, 1290180467, 3, '89.123.100.171'),
(5958, 1290180467, 3, '77.18.14.225'),
(5959, 1290180467, 3, '119.152.42.158'),
(5960, 1290180467, 3, '117.206.89.12'),
(5961, 1290180467, 3, '112.207.120.122'),
(5962, 1290180467, 3, '125.26.97.197'),
(5963, 1290180467, 3, '59.161.143.219'),
(5964, 1290180467, 3, '121.1.55.85'),
(5965, 1290180467, 3, '118.174.86.252'),
(5966, 1290180467, 3, '175.144.6.163'),
(5967, 1290180467, 3, '84.52.31.6'),
(5968, 1290180467, 3, '86.153.183.17'),
(5969, 1290180467, 3, '79.119.146.45'),
(5970, 1290180467, 3, '174.23.249.53'),
(5971, 1290180467, 3, '194.239.145.106'),
(5972, 1290180467, 3, '93.122.253.41'),
(5973, 1290180467, 3, '125.164.137.108'),
(5974, 1290180467, 3, '91.106.47.100'),
(5975, 1290180467, 3, '69.197.16.2'),
(5976, 1290180467, 3, '116.71.52.10'),
(5977, 1290180467, 3, '188.25.66.190'),
(5978, 1290180467, 3, '82.25.225.66'),
(5979, 1290180467, 3, '216.244.65.108'),
(5980, 1290180467, 3, '122.168.52.215'),
(5981, 1290180467, 3, '122.173.154.194'),
(5982, 1290180467, 3, '118.71.183.215'),
(5983, 1290180467, 3, '46.114.47.167'),
(5984, 1290180467, 3, '89.123.240.90'),
(5985, 1290180467, 3, '110.55.165.114'),
(5986, 1290180467, 3, '89.123.240.90'),
(5987, 1290180467, 3, '88.201.1.220'),
(5988, 1290180467, 3, '92.82.46.72'),
(5989, 1290180467, 3, '77.97.149.32'),
(5990, 1290180467, 3, '71.136.246.201'),
(5991, 1290180467, 3, '122.176.240.211'),
(5992, 1290180467, 3, '118.94.61.145'),
(5993, 1290180467, 3, '120.28.252.202'),
(5994, 1290180467, 3, '124.120.15.109'),
(5995, 1290180467, 3, '69.163.225.185'),
(5996, 1290180467, 3, '67.220.215.93'),
(5997, 1290180467, 3, '112.198.79.223'),
(5998, 1290180467, 3, '76.184.37.67'),
(5999, 1290180467, 3, '68.234.11.193'),
(6000, 1290180467, 3, '97.66.118.225'),
(6001, 1290180467, 3, '113.162.87.111'),
(6002, 1290180467, 3, '76.232.66.243'),
(6003, 1290180467, 3, '64.134.231.221'),
(6004, 1290180467, 3, '71.131.11.167'),
(6005, 1290180467, 3, '66.197.221.160'),
(6006, 1290180467, 3, '123.128.207.11'),
(6007, 1290180467, 3, '125.161.216.151'),
(6008, 1290180467, 3, '173.171.50.92'),
(6009, 1290180467, 3, '1.23.73.43'),
(6010, 1290180467, 3, '59.95.6.51'),
(6011, 1290180467, 3, '114.108.217.77'),
(6012, 1290180467, 3, '112.202.52.207'),
(6013, 1290180467, 3, '99.252.45.141'),
(6014, 1290180467, 3, '79.113.122.105'),
(6015, 1290180467, 3, '112.204.121.246'),
(6016, 1290180467, 3, '75.163.158.152'),
(6017, 1290180467, 3, '72.208.224.85'),
(6018, 1290180467, 3, '80.56.76.221'),
(6019, 1290180467, 3, '64.62.196.31'),
(6020, 1290180467, 3, '116.71.43.181'),
(6021, 1290180467, 3, '193.124.17.125'),
(6022, 1290180467, 3, '89.123.67.206'),
(6023, 1290180467, 3, '97.121.190.49'),
(6024, 1290180467, 3, '198.180.17.51'),
(6025, 1290180467, 3, '98.207.81.241'),
(6026, 1290180467, 3, '208.98.45.121'),
(6027, 1290180467, 3, '96.19.209.26'),
(6028, 1290180467, 3, '121.54.1.18'),
(6029, 1290180467, 3, '92.1.44.184'),
(6030, 1290180467, 3, '119.73.38.94'),
(6031, 1290180467, 3, '119.153.101.37'),
(6032, 1290180467, 3, '121.97.219.199'),
(6033, 1290180467, 3, '213.105.49.57'),
(6034, 1290180467, 3, '119.94.204.197'),
(6035, 1290180467, 3, '71.204.5.217'),
(6036, 1290180467, 3, '125.24.25.231'),
(6037, 1290180467, 3, '112.202.231.69'),
(6038, 1290180467, 3, '99.234.52.6'),
(6039, 1290180467, 3, '117.192.18.119'),
(6040, 1290180467, 3, '108.108.232.141'),
(6041, 1290180467, 3, '174.140.169.120'),
(6042, 1290180467, 3, '67.172.103.92'),
(6043, 1290180467, 3, '62.254.75.35'),
(6044, 1290180467, 3, '86.29.126.70'),
(6045, 1290180467, 3, '117.2.15.83'),
(6046, 1290180467, 3, '178.63.231.27'),
(6047, 1290180467, 3, '116.71.40.36'),
(6048, 1290180467, 3, '68.225.227.193'),
(6049, 1290180467, 3, '71.48.225.82'),
(6050, 1290180467, 3, '58.27.169.230'),
(6051, 1290180467, 3, '91.104.6.213'),
(6052, 1290180467, 3, '119.152.72.67'),
(6053, 1290180467, 3, '151.20.248.38'),
(6054, 1290180467, 3, '119.157.30.18'),
(6055, 1290180467, 3, '71.136.232.132'),
(6056, 1290180467, 3, '112.201.105.186'),
(6057, 1290180467, 3, '112.204.89.152'),
(6058, 1290180467, 3, '189.3.177.146'),
(6059, 1290180467, 3, '180.190.182.61'),
(6060, 1290180467, 3, '79.172.242.142'),
(6061, 1290180467, 3, '59.96.135.149'),
(6062, 1290180467, 3, '124.6.181.169'),
(6063, 1290180467, 3, '122.172.20.184'),
(6064, 1290180467, 3, '75.173.252.60'),
(6065, 1290180467, 3, '124.157.178.184'),
(6066, 1290180467, 3, '113.161.161.122'),
(6067, 1290180467, 3, '77.126.51.123'),
(6068, 1290180467, 3, '118.91.182.97'),
(6069, 1290180467, 3, '94.5.26.161'),
(6070, 1290180467, 3, '64.120.51.151'),
(6071, 1290180467, 3, '117.206.11.61'),
(6072, 1290180467, 3, '75.176.185.6'),
(6073, 1290180467, 3, '79.176.44.34'),
(6074, 1290180467, 3, '122.174.152.76'),
(6075, 1290180467, 3, '85.106.132.204'),
(6076, 1290180467, 3, '99.34.17.188'),
(6077, 1290180467, 3, '70.28.24.89'),
(6078, 1290180467, 3, '84.0.68.15'),
(6079, 1290180467, 3, '77.4.4.66'),
(6080, 1290180467, 3, '117.196.226.37'),
(6081, 1290180467, 3, '94.120.209.238'),
(6082, 1290180467, 3, '77.4.4.66'),
(6083, 1290180467, 3, '86.132.33.124'),
(6084, 1290180467, 3, '78.160.8.34'),
(6085, 1290180467, 3, '112.202.65.56'),
(6086, 1290180467, 3, '93.158.65.174'),
(6087, 1290180467, 3, '70.112.38.182'),
(6088, 1290180467, 3, '81.174.163.184'),
(6089, 1290180467, 3, '81.86.49.0'),
(6090, 1290180467, 3, '121.54.34.4'),
(6091, 1290180467, 3, '86.132.33.124'),
(6092, 1290180467, 3, '77.76.44.179'),
(6093, 1290180467, 3, '122.161.71.236'),
(6094, 1290180467, 3, '59.103.192.228'),
(6095, 1290180467, 3, '113.22.139.195'),
(6096, 1290180467, 3, '94.209.106.17'),
(6097, 1290180467, 3, '151.57.24.71'),
(6098, 1290180467, 3, '69.147.240.22'),
(6099, 1290180467, 3, '124.171.95.42'),
(6100, 1290180467, 3, '216.244.65.80'),
(6101, 1290180467, 3, '97.115.194.237'),
(6102, 1290180467, 3, '188.26.168.231'),
(6103, 1290180467, 3, '92.23.12.244'),
(6104, 1290180467, 3, '89.123.95.177'),
(6105, 1290180467, 3, '71.75.138.163'),
(6106, 1290180467, 3, '110.55.47.234'),
(6107, 1290180467, 3, '173.66.59.27'),
(6108, 1290180467, 3, '125.60.235.201'),
(6109, 1290180467, 3, '173.172.71.19'),
(6110, 1290180467, 3, '117.242.224.11'),
(6111, 1290180467, 3, '69.31.101.62'),
(6112, 1290180467, 3, '71.52.37.102'),
(6113, 1290180467, 3, '76.167.68.226'),
(6114, 1290180467, 3, '117.242.224.11'),
(6115, 1290180467, 3, '83.29.169.148'),
(6116, 1290180467, 3, '117.242.224.11'),
(6117, 1290180467, 3, '124.6.181.185'),
(6118, 1290180467, 3, '122.168.111.6'),
(6119, 1290180467, 3, '116.71.43.181'),
(6120, 1290180467, 3, '217.44.58.186'),
(6121, 1290180467, 3, '98.228.229.162'),
(6122, 1290180467, 3, '123.26.124.114'),
(6123, 1290180467, 3, '117.242.224.93'),
(6124, 1290180467, 3, '173.208.77.41'),
(6125, 1290180467, 3, '76.73.113.67'),
(6126, 1290180467, 3, '78.2.92.113'),
(6127, 1290180467, 3, '92.24.247.19'),
(6128, 1290180467, 3, '84.110.124.238'),
(6129, 1290180467, 3, '117.242.224.117'),
(6130, 1290180467, 3, '121.243.44.34'),
(6131, 1290180467, 3, '213.229.87.21'),
(6132, 1290180467, 3, '204.45.78.194'),
(6133, 1290180467, 3, '71.57.191.189'),
(6134, 1290180467, 3, '115.189.222.173'),
(6135, 1290180467, 3, '89.123.124.126'),
(6136, 1290180467, 3, '203.161.94.42'),
(6137, 1290180467, 3, '115.134.194.178'),
(6138, 1290180467, 3, '113.162.87.148'),
(6139, 1290180467, 3, '203.87.192.30'),
(6140, 1290180467, 3, '112.198.247.133'),
(6141, 1290180467, 3, '59.61.12.27'),
(6142, 1290180467, 3, '74.179.115.85'),
(6143, 1290180467, 3, '97.121.185.10'),
(6144, 1290180467, 3, '180.178.145.70'),
(6145, 1290180467, 3, '165.228.153.88'),
(6146, 1290180467, 3, '77.208.74.20'),
(6147, 1290180467, 3, '90.210.158.83'),
(6148, 1290180467, 3, '165.228.153.88'),
(6149, 1290180467, 3, '24.145.1.147'),
(6150, 1290180467, 3, '117.242.224.57'),
(6151, 1290180467, 3, '70.230.197.12'),
(6152, 1290180467, 3, '70.54.135.13'),
(6153, 1290180467, 3, '58.185.198.215'),
(6154, 1290180467, 3, '116.21.124.101'),
(6155, 1290180467, 3, '173.208.100.91'),
(6156, 1290180467, 3, '113.162.87.87'),
(6157, 1290180467, 3, '120.28.231.3'),
(6158, 1290180467, 3, '79.183.6.199'),
(6159, 1290180467, 3, '67.162.72.169'),
(6160, 1290180467, 3, '173.218.230.14'),
(6161, 1290180467, 3, '85.180.81.234'),
(6162, 1290180467, 3, '41.226.173.235'),
(6163, 1290180467, 3, '24.141.14.30'),
(6164, 1290180467, 3, '112.202.68.99'),
(6165, 1290180467, 3, '76.123.144.244'),
(6166, 1290180467, 3, '208.86.3.21'),
(6167, 1290180467, 3, '109.153.211.189'),
(6168, 1290180467, 3, '76.99.172.73'),
(6169, 1290180467, 3, '91.110.81.87'),
(6170, 1290180467, 3, '113.168.244.36'),
(6171, 1290180467, 3, '77.125.86.155'),
(6172, 1290180467, 3, '83.113.92.210'),
(6173, 1290180467, 3, '174.36.32.132'),
(6174, 1290180467, 3, '115.133.25.208'),
(6175, 1290180467, 3, '110.159.253.19'),
(6176, 1290180467, 3, '128.241.44.92'),
(6177, 1290180467, 3, '221.206.102.236'),
(6178, 1290180467, 3, '87.68.230.83'),
(6179, 1290180467, 3, '84.50.164.77'),
(6180, 1290180467, 3, '217.201.91.180'),
(6181, 1290180467, 3, '120.28.220.218'),
(6182, 1290180467, 3, '204.45.71.187'),
(6183, 1290180467, 3, '128.241.44.92'),
(6184, 1290180467, 3, '117.241.104.166'),
(6185, 1290180467, 3, '86.150.24.60'),
(6186, 1290180467, 3, '64.38.197.217'),
(6187, 1290180467, 3, '217.130.113.75'),
(6188, 1290180467, 3, '112.200.109.64'),
(6189, 1290180467, 3, '180.190.180.7'),
(6190, 1290180467, 3, '180.190.189.31'),
(6191, 1290180467, 3, '110.55.3.183'),
(6192, 1290180467, 3, '125.163.72.208'),
(6193, 1290180467, 3, '112.198.211.86'),
(6194, 1290180467, 3, '80.57.51.185'),
(6195, 1290180467, 3, '115.118.154.127'),
(6196, 1290180467, 3, '93.132.166.108'),
(6197, 1290180467, 3, '86.176.43.52'),
(6198, 1290180467, 3, '84.50.164.77'),
(6199, 1290180467, 3, '71.201.127.132'),
(6200, 1290180467, 3, '41.238.111.13'),
(6201, 1290180467, 3, '77.125.86.155'),
(6202, 1290180467, 3, '122.174.92.79'),
(6203, 1290180467, 3, '120.28.203.170'),
(6204, 1290180467, 3, '86.27.28.98'),
(6205, 1290180467, 3, '174.89.48.85'),
(6206, 1290180467, 3, '84.228.220.184'),
(6207, 1290180467, 3, '97.121.191.59'),
(6208, 1290180467, 3, '92.9.249.161'),
(6209, 1290180467, 3, '84.50.163.161'),
(6210, 1290180467, 3, '120.28.221.185'),
(6211, 1290180467, 3, '125.164.100.15'),
(6212, 1290180467, 3, '124.253.45.107'),
(6213, 1290180467, 3, '122.52.149.74'),
(6214, 1290180467, 3, '122.161.84.211'),
(6215, 1290180467, 3, '187.198.168.219'),
(6216, 1290180467, 3, '147.46.114.4'),
(6217, 1290180467, 3, '67.21.68.61'),
(6218, 1290180467, 3, '113.168.249.254'),
(6219, 1290180467, 3, '115.135.220.251'),
(6220, 1290180467, 3, '76.2.169.165'),
(6221, 1290180467, 3, '120.28.209.95'),
(6222, 1290180467, 3, '115.189.206.87'),
(6223, 1290180467, 3, '204.152.219.49'),
(6224, 1290180467, 3, '79.117.230.230'),
(6225, 1290180467, 3, '187.198.168.219'),
(6226, 1290180467, 3, '188.26.171.107'),
(6227, 1290180467, 3, '84.50.162.151'),
(6228, 1290180467, 3, '88.237.210.209'),
(6229, 1290180467, 3, '41.151.16.129'),
(6230, 1290180467, 3, '67.161.54.140'),
(6231, 1290180467, 3, '68.192.25.224'),
(6232, 1290180467, 3, '79.117.230.230'),
(6233, 1290180467, 3, '75.158.50.109'),
(6234, 1290180467, 3, '122.174.82.125'),
(6235, 1290180467, 3, '188.62.82.43'),
(6236, 1290180467, 3, '122.52.149.14'),
(6237, 1290180467, 3, '79.117.230.230'),
(6238, 1290180467, 3, '71.225.79.87'),
(6239, 1290180467, 3, '77.126.6.218'),
(6240, 1290180467, 3, '204.45.78.180'),
(6241, 1290180467, 3, '79.114.212.52'),
(6242, 1290180467, 3, '90.196.141.203'),
(6243, 1290180467, 3, '112.202.31.129'),
(6244, 1290180467, 3, '117.241.104.70'),
(6245, 1290180467, 3, '207.7.141.151'),
(6246, 1290180467, 3, '68.54.249.222'),
(6247, 1290180467, 3, '86.150.115.197'),
(6248, 1290180467, 3, '173.234.87.21'),
(6249, 1290180467, 3, '173.234.48.225'),
(6250, 1290180467, 3, '82.120.14.78'),
(6251, 1290180467, 3, '82.131.86.117'),
(6252, 1290180467, 3, '120.28.222.221'),
(6253, 1290180467, 3, '79.182.39.211'),
(6254, 1290180467, 3, '175.144.44.242'),
(6255, 1290180467, 3, '92.231.217.232'),
(6256, 1290180467, 3, '90.200.53.89'),
(6257, 1290180467, 3, '206.217.219.59'),
(6258, 1290180467, 3, '83.55.73.163'),
(6259, 1290180467, 3, '212.29.192.107'),
(6260, 1290180467, 3, '208.188.3.39'),
(6261, 1290180467, 3, '112.202.78.73'),
(6262, 1290180467, 3, '180.190.174.130'),
(6263, 1290180467, 3, '222.155.116.252'),
(6264, 1290180467, 3, '124.6.181.183'),
(6265, 1290180467, 3, '115.97.98.55'),
(6266, 1290180467, 3, '85.196.204.243'),
(6267, 1290180467, 3, '68.68.108.34'),
(6268, 1290180467, 3, '125.24.23.250'),
(6269, 1290180467, 3, '117.192.246.195'),
(6270, 1290180467, 3, '216.155.158.161'),
(6271, 1290180467, 3, '119.131.4.116'),
(6272, 1290180467, 3, '206.217.219.54'),
(6273, 1290180467, 3, '209.222.133.188'),
(6274, 1290180467, 3, '87.68.157.156'),
(6275, 1290180467, 3, '97.103.12.73'),
(6276, 1290180467, 3, '69.162.160.185'),
(6277, 1290180467, 3, '174.140.161.50'),
(6278, 1290180467, 3, '64.120.55.51'),
(6279, 1290180467, 3, '124.182.14.215'),
(6280, 1290180467, 3, '58.27.204.156'),
(6281, 1290180467, 3, '68.16.15.223'),
(6282, 1290180467, 3, '68.16.15.223'),
(6283, 1290180467, 3, '67.180.218.61'),
(6284, 1290180467, 3, '71.49.205.211'),
(6285, 1290180467, 3, '124.6.181.184'),
(6286, 1290180467, 3, '180.200.237.186'),
(6287, 1290180467, 3, '109.166.128.184'),
(6288, 1290180467, 3, '120.28.199.185'),
(6289, 1290180467, 3, '115.186.25.129'),
(6290, 1290180467, 3, '110.159.74.110'),
(6291, 1290180467, 3, '92.48.88.210'),
(6292, 1290180467, 3, '206.251.44.106'),
(6293, 1290180467, 3, '203.128.250.28'),
(6294, 1290180467, 3, '98.227.170.113'),
(6295, 1290180467, 3, '115.134.26.56'),
(6296, 1290180467, 3, '77.75.167.154'),
(6297, 1290180467, 3, '86.142.149.220'),
(6298, 1290180467, 3, '70.181.47.185'),
(6299, 1290180467, 3, '178.162.168.64'),
(6300, 1290180467, 3, '86.185.151.172'),
(6301, 1290180467, 3, '112.207.164.6'),
(6302, 1290180467, 3, '58.27.158.101'),
(6303, 1290180467, 3, '85.217.209.126'),
(6304, 1290180467, 3, '122.52.149.60'),
(6305, 1290180467, 3, '120.28.231.206'),
(6306, 1290180467, 3, '82.23.66.86'),
(6307, 1290180467, 3, '89.123.98.239'),
(6308, 1290180467, 3, '41.151.17.163'),
(6309, 1290180467, 3, '206.251.44.106'),
(6310, 1290180467, 3, '89.123.108.136'),
(6311, 1290180467, 3, '112.202.109.189'),
(6312, 1290180467, 3, '122.168.61.147'),
(6313, 1290180467, 3, '88.234.199.142'),
(6314, 1290180467, 3, '183.80.238.206'),
(6315, 1290180467, 3, '124.157.203.118'),
(6316, 1290180467, 3, '117.242.224.45'),
(6317, 1290180467, 3, '77.163.56.178'),
(6318, 1290180467, 3, '221.178.40.25'),
(6319, 1290180467, 3, '41.238.27.11'),
(6320, 1290180467, 3, '216.48.162.59'),
(6321, 1290180467, 3, '203.82.92.117'),
(6322, 1290180467, 3, '76.10.212.83'),
(6323, 1290180467, 3, '97.121.183.203'),
(6324, 1290180467, 3, '122.169.65.224'),
(6325, 1290180467, 3, '183.5.25.34'),
(6326, 1290180467, 3, '112.198.64.37'),
(6327, 1290180467, 3, '115.166.23.35'),
(6328, 1290180467, 3, '97.121.189.156'),
(6329, 1290180467, 3, '75.163.158.234'),
(6330, 1290180467, 3, '24.155.68.216'),
(6331, 1290180467, 3, '221.206.103.232'),
(6332, 1290180467, 3, '120.28.249.31'),
(6333, 1290180467, 3, '97.121.176.138'),
(6334, 1290180467, 3, '98.143.144.79'),
(6335, 1290180467, 3, '125.78.241.118'),
(6336, 1290180467, 3, '98.211.64.30'),
(6337, 1290180467, 3, '209.107.217.11'),
(6338, 1290180467, 3, '119.157.66.109'),
(6339, 1290180467, 3, '216.66.59.41'),
(6340, 1290180467, 3, '112.198.214.204'),
(6341, 1290180467, 3, '173.13.130.235'),
(6342, 1290180467, 3, '128.241.41.216'),
(6343, 1290180467, 3, '109.166.140.169'),
(6344, 1290180467, 3, '208.83.63.219'),
(6345, 1290180467, 3, '71.214.165.216'),
(6346, 1290180467, 3, '91.216.105.11'),
(6347, 1290180467, 3, '85.118.172.97'),
(6348, 1290180467, 3, '62.98.162.18'),
(6349, 1290180467, 3, '77.126.145.202'),
(6350, 1290180467, 3, '174.142.98.109'),
(6351, 1290180467, 3, '61.90.66.90'),
(6352, 1290180467, 3, '72.250.163.103'),
(6353, 1290180467, 3, '204.45.78.227'),
(6354, 1290180467, 3, '60.241.174.95'),
(6355, 1290180467, 3, '61.247.243.95'),
(6356, 1290180467, 3, '84.50.163.140'),
(6357, 1290180467, 3, '112.202.64.143'),
(6358, 1290180467, 3, '112.202.39.210'),
(6359, 1290180467, 3, '112.202.64.143'),
(6360, 1290180467, 3, '110.139.2.30'),
(6361, 1290180467, 3, '173.208.77.40'),
(6362, 1290180467, 3, '77.85.96.245'),
(6363, 1290180467, 3, '173.234.116.168'),
(6364, 1290180467, 3, '92.227.192.31'),
(6365, 1290180467, 3, '218.186.8.229'),
(6366, 1290180467, 3, '79.144.151.3'),
(6367, 1290180467, 3, '82.36.131.228'),
(6368, 1290180467, 3, '112.202.5.29'),
(6369, 1290180467, 3, '64.38.197.206'),
(6370, 1290180467, 3, '123.26.121.253'),
(6371, 1290180467, 3, '220.161.117.61'),
(6372, 1290180467, 3, '59.161.142.226'),
(6373, 1290180467, 3, '122.163.128.82'),
(6374, 1290180467, 3, '117.242.224.56'),
(6375, 1290180467, 3, '125.164.192.134'),
(6376, 1290180467, 3, '112.207.186.165'),
(6377, 1290180467, 3, '122.168.252.249'),
(6378, 1290180467, 3, '122.162.255.59'),
(6379, 1290180467, 3, '125.26.88.137'),
(6380, 1290180467, 3, '122.169.50.124'),
(6381, 1290180467, 3, '202.78.85.37'),
(6382, 1290180467, 3, '69.22.184.54'),
(6383, 1290180467, 3, '203.92.52.166'),
(6384, 1290180467, 3, '201.130.5.165'),
(6385, 1290180467, 3, '76.103.226.99'),
(6386, 1290180467, 3, '174.52.148.216'),
(6387, 1290180467, 3, '216.244.65.120'),
(6388, 1290180467, 3, '166.237.222.108'),
(6389, 1290180467, 3, '72.198.37.82'),
(6390, 1290180467, 3, '209.237.224.106'),
(6391, 1290180467, 3, '64.38.197.222'),
(6392, 1290180467, 3, '99.30.65.64'),
(6393, 1290180467, 3, '187.198.128.26'),
(6394, 1290180467, 3, '75.72.83.169'),
(6395, 1290180467, 3, '82.131.12.82'),
(6396, 1290180467, 3, '64.231.176.3'),
(6397, 1290180467, 3, '92.81.134.70'),
(6398, 1290180467, 3, '92.82.60.240'),
(6399, 1290180467, 3, '110.55.170.115'),
(6400, 1290180467, 3, '80.144.14.41'),
(6401, 1290180467, 3, '68.82.232.122'),
(6402, 1290180467, 3, '208.86.3.22'),
(6403, 1290180467, 3, '89.238.166.103'),
(6404, 1290180467, 3, '74.115.160.201'),
(6405, 1290180467, 3, '217.189.167.166'),
(6406, 1290180467, 3, '119.94.204.109'),
(6407, 1290180467, 3, '122.176.196.33'),
(6408, 1290180467, 3, '74.62.32.106'),
(6409, 1290180467, 3, '71.57.27.25'),
(6410, 1290180467, 3, '117.204.169.147'),
(6411, 1290180467, 3, '124.6.181.180'),
(6412, 1290180467, 3, '208.98.45.100'),
(6413, 1290180467, 3, '203.87.178.19'),
(6414, 1290180467, 3, '76.19.134.189'),
(6415, 1290180467, 3, '195.174.167.96'),
(6416, 1290180467, 3, '70.136.141.120'),
(6417, 1290180467, 3, '84.203.114.250'),
(6418, 1290180467, 3, '70.136.141.120'),
(6419, 1290180467, 3, '98.142.212.164'),
(6420, 1290180467, 3, '94.173.153.8'),
(6421, 1290180467, 3, '189.115.127.209'),
(6422, 1290180467, 3, '83.53.227.30'),
(6423, 1290180467, 3, '213.15.255.205'),
(6424, 1290180467, 3, '116.193.170.25'),
(6425, 1290180467, 3, '87.68.217.45'),
(6426, 1290180467, 3, '125.26.82.25'),
(6427, 1290180467, 3, '24.159.60.255'),
(6428, 1290180467, 3, '41.211.226.157'),
(6429, 1290180467, 3, '77.126.8.157'),
(6430, 1290180467, 3, '90.200.52.50'),
(6431, 1290180467, 3, '174.51.119.69'),
(6432, 1290180467, 3, '74.115.212.25'),
(6433, 1290180467, 3, '87.68.217.45'),
(6434, 1290180467, 3, '87.68.217.45'),
(6435, 1290180467, 3, '87.105.164.6'),
(6436, 1290180467, 3, '80.90.196.136'),
(6437, 1290180467, 3, '86.179.30.68'),
(6438, 1290180467, 3, '113.162.87.159'),
(6439, 1290180467, 3, '125.164.155.84'),
(6440, 1290180467, 3, '180.200.239.18'),
(6441, 1290180467, 3, '117.242.224.58'),
(6442, 1290180467, 3, '121.247.245.32'),
(6443, 1290180467, 3, '58.27.220.238'),
(6444, 1290180467, 3, '115.242.25.33'),
(6445, 1290180467, 3, '86.31.196.111'),
(6446, 1290180467, 3, '117.18.231.10'),
(6447, 1290180467, 3, '218.248.84.94'),
(6448, 1290180467, 3, '203.87.178.25'),
(6449, 1290180467, 3, '98.212.57.12'),
(6450, 1290180467, 3, '190.43.115.55'),
(6451, 1290180467, 3, '83.55.67.162'),
(6452, 1290180467, 3, '72.242.114.242'),
(6453, 1290180467, 3, '79.112.118.75'),
(6454, 1290180467, 3, '63.225.44.233'),
(6455, 1290180467, 3, '115.118.85.99'),
(6456, 1290180467, 3, '89.123.93.25'),
(6457, 1290180467, 3, '64.62.196.25'),
(6458, 1290180467, 3, '112.201.114.209'),
(6459, 1290180467, 3, '122.161.19.206'),
(6460, 1290180467, 3, '109.96.73.61'),
(6461, 1290180467, 3, '115.134.176.198'),
(6462, 1290180467, 3, '122.161.85.150'),
(6463, 1290180467, 3, '92.37.42.252'),
(6464, 1290180467, 3, '92.37.42.252'),
(6465, 1290180467, 3, '79.134.174.203'),
(6466, 1290180467, 3, '69.162.143.16'),
(6467, 1290180467, 3, '115.133.215.236'),
(6468, 1290180467, 3, '58.27.158.167'),
(6469, 1290180467, 3, '218.79.81.166'),
(6470, 1290180467, 3, '122.163.63.142'),
(6471, 1290180467, 3, '173.234.94.245'),
(6472, 1290180467, 3, '117.199.123.142'),
(6473, 1290180467, 3, '112.202.15.147'),
(6474, 1290180467, 3, '216.155.145.89'),
(6475, 1290180467, 3, '121.1.45.2'),
(6476, 1290180467, 3, '124.124.204.75'),
(6477, 1290180467, 3, '117.242.224.70'),
(6478, 1290180467, 3, '58.27.151.23'),
(6479, 1290180467, 3, '202.70.51.176'),
(6480, 1290180467, 3, '180.180.26.126'),
(6481, 1290180467, 3, '95.144.80.117'),
(6482, 1290180467, 3, '190.247.25.70'),
(6483, 1290180467, 3, '85.246.220.47'),
(6484, 1290180467, 3, '85.246.220.47'),
(6485, 1290180467, 3, '218.59.71.163'),
(6486, 1290180467, 3, '59.90.137.17'),
(6487, 1290180467, 3, '174.89.51.21'),
(6488, 1290180467, 3, '122.172.159.105'),
(6489, 1290180467, 3, '124.129.14.34'),
(6490, 1290180467, 3, '115.189.235.229'),
(6491, 1290180467, 3, '77.208.192.147'),
(6492, 1290180467, 3, '81.110.0.16'),
(6493, 1290180467, 3, '89.123.74.78'),
(6494, 1290180467, 3, '206.217.219.66'),
(6495, 1290180467, 3, '72.94.245.244'),
(6496, 1290180467, 3, '109.96.90.228'),
(6497, 1290180467, 3, '58.11.37.47'),
(6498, 1290180467, 3, '173.208.18.39'),
(6499, 1290180467, 3, '82.6.42.99'),
(6500, 1290180467, 3, '121.96.169.2'),
(6501, 1290180467, 3, '72.243.167.242'),
(6502, 1290180467, 3, '24.138.50.190'),
(6503, 1290180467, 3, '122.168.182.140'),
(6504, 1290180467, 3, '122.163.183.235'),
(6505, 1290180467, 3, '203.177.74.144'),
(6506, 1290180467, 3, '115.87.148.187'),
(6507, 1290180467, 3, '117.205.1.86'),
(6508, 1290180467, 3, '79.178.3.127'),
(6509, 1290180467, 3, '72.3.240.250'),
(6510, 1290180467, 3, '79.177.52.145'),
(6511, 1290180467, 3, '89.196.15.245'),
(6512, 1290180467, 3, '68.234.11.41'),
(6513, 1290180467, 3, '95.42.176.215'),
(6514, 1290180467, 3, '86.138.96.5'),
(6515, 1290180467, 3, '117.200.180.149'),
(6516, 1290180467, 3, '92.14.115.106'),
(6517, 1290180467, 3, '109.67.36.77'),
(6518, 1290180467, 3, '58.9.47.163'),
(6519, 1290180467, 3, '121.97.174.118'),
(6520, 1290180467, 3, '88.7.64.63'),
(6521, 1290180467, 3, '173.208.23.198'),
(6522, 1290180467, 3, '115.135.200.205'),
(6523, 1290180467, 3, '58.9.70.235'),
(6524, 1290180467, 3, '113.168.244.76'),
(6525, 1290180467, 3, '67.21.69.163'),
(6526, 1290180467, 3, '117.198.245.141'),
(6527, 1290180467, 3, '124.6.181.177'),
(6528, 1290180467, 3, '59.95.33.8'),
(6529, 1290180467, 3, '112.200.32.58'),
(6530, 1290180467, 3, '59.178.150.226'),
(6531, 1290180467, 3, '122.178.134.156'),
(6532, 1290180467, 3, '120.28.235.78'),
(6533, 1290180467, 3, '203.111.229.74'),
(6534, 1290180467, 3, '98.70.143.80'),
(6535, 1290180467, 3, '122.178.134.156'),
(6536, 1290180467, 3, '58.27.220.249'),
(6537, 1290180467, 3, '110.55.174.246'),
(6538, 1290180467, 3, '124.157.203.89'),
(6539, 1290180467, 3, '187.198.215.170'),
(6540, 1290180467, 3, '202.78.85.34'),
(6541, 1290180467, 3, '116.209.95.23'),
(6542, 1290180467, 3, '221.206.112.184'),
(6543, 1290180467, 3, '98.248.161.85'),
(6544, 1290180467, 3, '98.192.232.247'),
(6545, 1290180467, 3, '76.125.77.71'),
(6546, 1290180467, 3, '124.6.181.171'),
(6547, 1290180467, 3, '113.168.249.87'),
(6548, 1290180467, 3, '115.134.193.150'),
(6549, 1290180467, 3, '203.213.6.73'),
(6550, 1290180467, 3, '112.207.148.115'),
(6551, 1290180467, 3, '109.129.198.122'),
(6552, 1290180467, 3, '122.163.217.102'),
(6553, 1290180467, 3, '208.98.45.119'),
(6554, 1290180467, 3, '89.123.75.61'),
(6555, 1290180467, 3, '86.96.229.85'),
(6556, 1290180467, 3, '99.230.224.237'),
(6557, 1290180467, 3, '92.253.27.202'),
(6558, 1290180467, 3, '90.196.141.133'),
(6559, 1290180467, 3, '92.82.225.175'),
(6560, 1290180467, 3, '188.72.227.116'),
(6561, 1290180467, 3, '187.198.241.149'),
(6562, 1290180467, 3, '112.202.104.169'),
(6563, 1290180467, 3, '78.86.88.55'),
(6564, 1290180467, 3, '174.141.55.70'),
(6565, 1290180467, 3, '121.97.116.26'),
(6566, 1290180467, 3, '58.9.41.181'),
(6567, 1290180467, 3, '98.206.176.86'),
(6568, 1290180467, 3, '41.237.235.124'),
(6569, 1290180467, 3, '115.72.138.47'),
(6570, 1290180467, 3, '94.192.65.197'),
(6571, 1290180467, 3, '67.21.69.143'),
(6572, 1290180467, 3, '67.21.68.59'),
(6573, 1290180467, 3, '41.254.0.238'),
(6574, 1290180467, 3, '122.163.251.211'),
(6575, 1290180467, 3, '122.174.87.92'),
(6576, 1290180467, 3, '110.139.46.242'),
(6577, 1290180467, 3, '122.178.182.95'),
(6578, 1290180467, 3, '117.242.224.81'),
(6579, 1290180467, 3, '120.28.208.47'),
(6580, 1290180467, 3, '122.169.253.249'),
(6581, 1290180467, 3, '124.190.27.244'),
(6582, 1290180467, 3, '124.148.193.5'),
(6583, 1290180467, 3, '66.79.163.12'),
(6584, 1290180467, 3, '204.45.61.148'),
(6585, 1290180467, 3, '99.74.75.126'),
(6586, 1290180467, 3, '59.93.214.55'),
(6587, 1290180467, 3, '112.202.71.237'),
(6588, 1290180467, 3, '92.239.55.114'),
(6589, 1290180467, 3, '208.100.27.182'),
(6590, 1290180467, 3, '38.119.107.114'),
(6591, 1290180467, 3, '119.152.101.189'),
(6592, 1290180467, 3, '66.234.239.195'),
(6593, 1290180467, 3, '89.123.15.221'),
(6594, 1290180467, 3, '62.65.197.56'),
(6595, 1290180467, 3, '58.60.177.113'),
(6596, 1290180467, 3, '112.202.0.148'),
(6597, 1290180467, 3, '80.42.184.37'),
(6598, 1290180467, 3, '206.217.219.19'),
(6599, 1290180467, 3, '69.175.89.234'),
(6600, 1290180467, 3, '76.173.189.193'),
(6601, 1290180467, 3, '122.144.113.113'),
(6602, 1290180467, 3, '99.229.101.223'),
(6603, 1290180467, 3, '69.31.101.64'),
(6604, 1290180467, 3, '79.114.251.180'),
(6605, 1290180467, 3, '114.143.67.98'),
(6606, 1290180467, 3, '115.164.14.66'),
(6607, 1290180467, 3, '24.83.211.217'),
(6608, 1290180467, 3, '173.234.175.206'),
(6609, 1290180467, 3, '91.216.105.16'),
(6610, 1290180467, 3, '69.162.131.125'),
(6611, 1290180467, 3, '124.6.181.166'),
(6612, 1290180467, 3, '97.118.224.241'),
(6613, 1290180467, 3, '117.204.96.219'),
(6614, 1290180467, 3, '165.228.80.41'),
(6615, 1290180467, 3, '208.84.193.178'),
(6616, 1290180467, 3, '59.58.158.171'),
(6617, 1290180467, 3, '113.170.234.208'),
(6618, 1290180467, 3, '122.161.237.149'),
(6619, 1290180467, 3, '117.242.224.53'),
(6620, 1290180467, 3, '189.176.119.45'),
(6621, 1290180467, 3, '120.28.217.93'),
(6622, 1290180467, 3, '58.69.31.14'),
(6623, 1290180467, 3, '120.28.221.199'),
(6624, 1290180467, 3, '204.124.182.206'),
(6625, 1290180467, 3, '98.234.204.36'),
(6626, 1290180467, 3, '81.227.178.214'),
(6627, 1290180467, 3, '94.23.149.50'),
(6628, 1290180467, 3, '41.251.143.173'),
(6629, 1290180467, 3, '92.15.254.230'),
(6630, 1290180467, 3, '113.166.56.220'),
(6631, 1290180467, 3, '114.143.49.57'),
(6632, 1290180467, 3, '124.83.19.113'),
(6633, 1290180467, 3, '89.123.126.47'),
(6634, 1290180467, 3, '60.217.146.76'),
(6635, 1290180467, 3, '71.204.153.136'),
(6636, 1290180467, 3, '95.42.155.3'),
(6637, 1290180467, 3, '58.27.157.84'),
(6638, 1290180467, 3, '112.206.141.43'),
(6639, 1290180467, 3, '64.62.196.29'),
(6640, 1290180467, 3, '62.98.161.81'),
(6641, 1290180467, 3, '89.123.15.221'),
(6642, 1290180467, 3, '115.135.18.89'),
(6643, 1290180467, 3, '123.24.159.109'),
(6644, 1290180467, 3, '75.126.147.242'),
(6645, 1290180467, 3, '61.247.243.10'),
(6646, 1290180467, 3, '113.53.215.61'),
(6647, 1290180467, 3, '89.123.101.0'),
(6648, 1290180467, 3, '119.157.5.180'),
(6649, 1290180467, 3, '75.163.156.61'),
(6650, 1290180467, 3, '188.165.133.115'),
(6651, 1290180467, 3, '89.123.126.197'),
(6652, 1290180467, 3, '72.211.213.248'),
(6653, 1290180467, 3, '94.23.72.210'),
(6654, 1290180467, 3, '72.89.85.154'),
(6655, 1290180467, 3, '75.163.156.140'),
(6656, 1290180467, 3, '122.52.148.59'),
(6657, 1290180467, 3, '120.28.205.65'),
(6658, 1290180467, 3, '216.244.65.95'),
(6659, 1290180467, 3, '221.206.101.88'),
(6660, 1290180467, 3, '98.211.253.107'),
(6661, 1290180467, 3, '61.19.65.114'),
(6662, 1290180467, 3, '217.174.60.24'),
(6663, 1290180467, 3, '115.187.46.10'),
(6664, 1290180467, 3, '122.178.156.247'),
(6665, 1290180467, 3, '203.92.52.142'),
(6666, 1290180467, 3, '122.163.83.228'),
(6667, 1290180467, 3, '41.202.209.71'),
(6668, 1290180467, 3, '66.71.244.27'),
(6669, 1290180467, 3, '112.202.82.210'),
(6670, 1290180467, 3, '217.174.60.252'),
(6671, 1290180467, 3, '67.21.65.207'),
(6672, 1290180467, 3, '120.28.223.251'),
(6673, 1290180467, 3, '94.75.253.244'),
(6674, 1290180467, 3, '58.27.150.236'),
(6675, 1290180467, 3, '180.190.179.191'),
(6676, 1290180467, 3, '89.123.98.120'),
(6677, 1290180467, 3, '70.32.45.243'),
(6678, 1290180467, 3, '189.33.100.80'),
(6679, 1290180467, 3, '79.243.171.181'),
(6680, 1290180467, 3, '208.94.243.34'),
(6681, 1290180467, 3, '97.121.178.72'),
(6682, 1290180467, 3, '113.168.241.185'),
(6683, 1290180467, 3, '68.234.11.67'),
(6684, 1290180467, 3, '175.138.68.243'),
(6685, 1290180467, 3, '112.135.29.148'),
(6686, 1290180467, 3, '112.202.25.97'),
(6687, 1290180467, 3, '74.115.212.40'),
(6688, 1290180467, 3, '130.94.69.107'),
(6689, 1290180467, 3, '180.190.132.161'),
(6690, 1290180467, 3, '86.157.211.16'),
(6691, 1290180467, 3, '188.153.53.2'),
(6692, 1290180467, 3, '173.183.232.94'),
(6693, 1290180467, 3, '68.7.162.253'),
(6694, 1290180467, 3, '99.89.125.207'),
(6695, 1290180467, 3, '110.139.75.198'),
(6696, 1290180467, 3, '24.126.202.244'),
(6697, 1290180467, 3, '122.144.116.40'),
(6698, 1290180467, 3, '188.26.168.105'),
(6699, 1290180467, 3, '206.248.163.17'),
(6700, 1290180467, 3, '108.124.79.105'),
(6701, 1290180467, 3, '93.177.139.33'),
(6702, 1290180467, 3, '86.61.52.57'),
(6703, 1290180467, 3, '77.208.211.9'),
(6704, 1290180467, 3, '24.251.42.187'),
(6705, 1290180467, 3, '75.173.252.226'),
(6706, 1290180467, 3, '123.117.191.248'),
(6707, 1290180467, 3, '59.92.123.7'),
(6708, 1290180467, 3, '124.253.45.60'),
(6709, 1290180467, 3, '113.169.155.23'),
(6710, 1290180467, 3, '122.163.155.42'),
(6711, 1290180467, 3, '117.198.226.233'),
(6712, 1290180467, 3, '81.169.171.191'),
(6713, 1290180467, 3, '70.246.226.188'),
(6714, 1290180467, 3, '173.234.2.9'),
(6715, 1290180467, 3, '64.69.33.99'),
(6716, 1290180467, 3, '41.7.158.194'),
(6717, 1290180467, 3, '86.68.212.115'),
(6718, 1290180467, 3, '65.162.75.176'),
(6719, 1290180467, 3, '68.9.48.207'),
(6720, 1290180467, 3, '70.31.239.73'),
(6721, 1290180467, 3, '89.123.107.116'),
(6722, 1290180467, 3, '89.123.107.116'),
(6723, 1290180467, 3, '199.71.215.105'),
(6724, 1290180467, 3, '117.193.139.184'),
(6725, 1290180467, 3, '173.234.92.148'),
(6726, 1290180467, 3, '79.114.251.228'),
(6727, 1290180467, 3, '67.21.69.157'),
(6728, 1290180467, 3, '67.21.65.226'),
(6729, 1290180467, 3, '113.168.255.164'),
(6730, 1290180467, 3, '97.89.235.99'),
(6731, 1290180467, 3, '222.155.104.7'),
(6732, 1290180467, 3, '68.0.181.36'),
(6733, 1290180467, 3, '120.28.223.37'),
(6734, 1290180467, 3, '115.189.253.185'),
(6735, 1290180467, 3, '70.67.229.219'),
(6736, 1290180467, 3, '90.208.17.230'),
(6737, 1290180467, 3, '67.172.4.159'),
(6738, 1290180467, 3, '110.136.151.126'),
(6739, 1290180467, 3, '58.27.220.91'),
(6740, 1290180467, 3, '78.2.58.172'),
(6741, 1290180467, 3, '173.246.211.174'),
(6742, 1290180467, 3, '188.26.170.33'),
(6743, 1290180467, 3, '121.96.177.51'),
(6744, 1290180467, 3, '124.176.71.105'),
(6745, 1290180467, 3, '67.21.69.176'),
(6746, 1290180467, 3, '180.190.160.74'),
(6747, 1290180467, 3, '112.202.75.156'),
(6748, 1290180467, 3, '97.121.176.88'),
(6749, 1290180467, 3, '122.178.156.247'),
(6750, 1290180467, 3, '124.253.44.120'),
(6751, 1290180467, 3, '99.232.31.77'),
(6752, 1290180467, 3, '93.81.129.135'),
(6753, 1290180467, 3, '119.82.66.55'),
(6754, 1290180467, 3, '122.161.66.168'),
(6755, 1290180467, 3, '122.52.149.114'),
(6756, 1290180467, 3, '68.71.158.55'),
(6757, 1290180467, 3, '75.163.159.111'),
(6758, 1290180467, 3, '113.168.255.164'),
(6759, 1290180467, 3, '217.33.159.210'),
(6760, 1290180467, 3, '92.79.178.142'),
(6761, 1290180467, 3, '68.234.11.134'),
(6762, 1290180467, 3, '117.200.181.207'),
(6763, 1290180467, 3, '121.97.174.131'),
(6764, 1290180467, 3, '82.124.163.137'),
(6765, 1290180467, 3, '71.131.131.10'),
(6766, 1290180467, 3, '98.70.44.206'),
(6767, 1290180467, 3, '113.162.87.144'),
(6768, 1290180467, 3, '125.164.148.88'),
(6769, 1290180467, 3, '67.21.69.171'),
(6770, 1290180467, 3, '99.49.37.238'),
(6771, 1290180467, 3, '61.177.142.230'),
(6772, 1290180467, 3, '122.163.96.170'),
(6773, 1290180467, 3, '97.121.180.39'),
(6774, 1290180467, 3, '79.117.230.237'),
(6775, 1290180467, 3, '202.129.234.228'),
(6776, 1290180467, 3, '69.197.15.124'),
(6777, 1290180467, 3, '124.6.181.161'),
(6778, 1290180467, 3, '122.161.61.117'),
(6779, 1290180467, 3, '69.98.229.69'),
(6780, 1290180467, 3, '79.112.106.181'),
(6781, 1290180467, 3, '122.178.129.228'),
(6782, 1290180467, 3, '202.133.60.187'),
(6783, 1290180467, 3, '110.54.156.34'),
(6784, 1290180467, 3, '122.161.15.104'),
(6785, 1290180467, 3, '112.135.14.53'),
(6786, 1290180467, 3, '122.173.168.114'),
(6787, 1290180467, 3, '122.174.102.131'),
(6788, 1290180467, 3, '125.23.220.199'),
(6789, 1290180467, 3, '117.242.224.4'),
(6790, 1290180467, 3, '112.198.246.66'),
(6791, 1290180467, 3, '97.121.181.154'),
(6792, 1290180467, 3, '112.135.14.53'),
(6793, 1290180467, 3, '81.156.52.187'),
(6794, 1290180467, 3, '58.27.157.94'),
(6795, 1290180467, 3, '195.228.25.66'),
(6796, 1290180467, 3, '122.169.76.153'),
(6797, 1290180467, 3, '67.21.68.34'),
(6798, 1290180467, 3, '41.226.196.147'),
(6799, 1290180467, 3, '124.6.181.121'),
(6800, 1290180467, 3, '112.202.101.181'),
(6801, 1290180467, 3, '67.212.185.100'),
(6802, 1290180467, 3, '122.161.116.149'),
(6803, 1290180467, 3, '178.36.43.152'),
(6804, 1290180467, 3, '84.61.162.126'),
(6805, 1290180467, 3, '98.216.51.22'),
(6806, 1290180467, 3, '98.229.179.14'),
(6807, 1290180467, 3, '58.11.37.11'),
(6808, 1290180467, 3, '95.144.76.174'),
(6809, 1290180467, 3, '122.162.192.66'),
(6810, 1290180467, 3, '89.123.109.164'),
(6811, 1290180467, 3, '203.87.178.24'),
(6812, 1290180467, 3, '80.212.158.253'),
(6813, 1290180467, 3, '110.159.33.88'),
(6814, 1290180467, 3, '117.200.182.148'),
(6815, 1290180467, 3, '117.200.182.148'),
(6816, 1290180467, 3, '83.21.21.208'),
(6817, 1290180467, 3, '75.27.190.236'),
(6818, 1290180467, 3, '90.216.194.67'),
(6819, 1290180467, 3, '67.202.119.81'),
(6820, 1290180467, 3, '67.68.41.59'),
(6821, 1290180467, 3, '178.32.45.5'),
(6822, 1290180467, 3, '71.33.73.20'),
(6823, 1290180467, 3, '75.103.0.178'),
(6824, 1290180467, 3, '195.242.152.13'),
(6825, 1290180467, 3, '119.30.39.56'),
(6826, 1290180467, 3, '58.27.219.155'),
(6827, 1290180467, 3, '222.154.58.114'),
(6828, 1290180467, 3, '69.171.160.21'),
(6829, 1290180467, 3, '70.62.99.50'),
(6830, 1290180467, 3, '96.43.138.16'),
(6831, 1290180467, 3, '196.210.151.228'),
(6832, 1290180467, 3, '68.234.11.111'),
(6833, 1290180467, 3, '68.68.108.3'),
(6834, 1290180467, 3, '142.167.163.218'),
(6835, 1290180467, 3, '190.120.231.38'),
(6836, 1290180467, 3, '98.214.240.59'),
(6837, 1290180467, 3, '92.82.48.222'),
(6838, 1290180467, 3, '173.234.116.23'),
(6839, 1290180467, 3, '92.232.180.4'),
(6840, 1290180467, 3, '112.198.64.39'),
(6841, 1290180467, 3, '122.183.210.205'),
(6842, 1290180467, 3, '91.206.183.238'),
(6843, 1290180467, 3, '84.92.211.227'),
(6844, 1290180467, 3, '67.212.185.78'),
(6845, 1290180467, 3, '83.253.77.222'),
(6846, 1290180467, 3, '201.76.211.246'),
(6847, 1290180467, 3, '70.137.155.173'),
(6848, 1290180467, 3, '113.53.49.136'),
(6849, 1290180467, 3, '122.161.26.100'),
(6850, 1290180467, 3, '124.190.208.22'),
(6851, 1290180467, 3, '58.27.154.145'),
(6852, 1290180467, 3, '112.202.89.247'),
(6853, 1290180467, 3, '121.97.103.153'),
(6854, 1290180467, 3, '222.153.237.159'),
(6855, 1290180467, 3, '72.8.142.71'),
(6856, 1290180467, 3, '200.7.178.72'),
(6857, 1290180467, 3, '71.131.0.123'),
(6858, 1290180467, 3, '83.21.212.78'),
(6859, 1290180467, 3, '91.201.66.85'),
(6860, 1290180467, 3, '123.125.156.142'),
(6861, 1290180467, 3, '121.97.101.239'),
(6862, 1290180467, 3, '189.77.8.107'),
(6863, 1290180467, 3, '203.92.52.129'),
(6864, 1290180467, 3, '113.168.254.46'),
(6865, 1290180467, 3, '68.71.51.33'),
(6866, 1290180467, 3, '81.233.86.244'),
(6867, 1290180467, 3, '88.254.75.170'),
(6868, 1290180467, 3, '187.198.237.184'),
(6869, 1290180467, 3, '203.177.75.233'),
(6870, 1290180467, 3, '173.208.124.238'),
(6871, 1290180467, 3, '68.71.58.169'),
(6872, 1290180467, 3, '110.55.166.107'),
(6873, 1290180467, 3, '120.28.240.95'),
(6874, 1290180467, 3, '68.234.11.230'),
(6875, 1290180467, 3, '67.21.68.42'),
(6876, 1290180467, 3, '120.36.4.41'),
(6877, 1290180467, 3, '94.242.25.178'),
(6878, 1290180467, 3, '115.117.148.252'),
(6879, 1290180467, 3, '97.75.175.106'),
(6880, 1290180467, 3, '188.153.17.226'),
(6881, 1290180467, 3, '72.68.68.24'),
(6882, 1290180467, 3, '80.226.55.223'),
(6883, 1290180467, 3, '98.174.241.62'),
(6884, 1290180467, 3, '93.212.119.188'),
(6885, 1290180467, 3, '82.128.24.176'),
(6886, 1290180467, 3, '203.87.178.23'),
(6887, 1290180467, 3, '64.38.197.212'),
(6888, 1290180467, 3, '119.94.201.57'),
(6889, 1290180467, 3, '69.197.13.66'),
(6890, 1290180467, 3, '98.142.212.126'),
(6891, 1290180467, 3, '98.210.100.235'),
(6892, 1290180467, 3, '78.2.72.184'),
(6893, 1290180467, 3, '122.144.118.47'),
(6894, 1290180467, 3, '90.206.85.92'),
(6895, 1290180467, 3, '69.147.242.155'),
(6896, 1290180467, 3, '94.8.34.144'),
(6897, 1290180467, 3, '59.92.108.242'),
(6898, 1290180467, 3, '93.137.50.143'),
(6899, 1290180467, 3, '88.233.42.120'),
(6900, 1290180467, 3, '204.124.182.82'),
(6901, 1290180467, 3, '112.198.78.93'),
(6902, 1290180467, 3, '90.45.213.173'),
(6903, 1290180467, 3, '78.129.196.77'),
(6904, 1290180467, 3, '173.234.44.140'),
(6905, 1290180467, 3, '122.161.127.5'),
(6906, 1290180467, 3, '203.51.125.182'),
(6907, 1290180467, 3, '180.190.158.111'),
(6908, 1290180467, 3, '119.153.32.198'),
(6909, 1290180467, 3, '122.166.151.163'),
(6910, 1290180467, 3, '70.44.199.114'),
(6911, 1290180467, 3, '77.4.1.103'),
(6912, 1290180467, 3, '208.98.55.86'),
(6913, 1290180467, 3, '112.198.247.247'),
(6914, 1290180467, 3, '202.71.106.148'),
(6915, 1290180467, 3, '83.9.30.217'),
(6916, 1290180467, 3, '116.71.50.61'),
(6917, 1290180467, 3, '69.22.184.8'),
(6918, 1290180467, 3, '68.234.11.104'),
(6919, 1290180467, 3, '117.242.224.6'),
(6920, 1290180467, 3, '122.160.247.46'),
(6921, 1290180467, 3, '122.162.114.164'),
(6922, 1290180467, 3, '61.247.243.115'),
(6923, 1290180467, 3, '93.158.65.174'),
(6924, 1290180467, 3, '88.9.105.19'),
(6925, 1290180467, 3, '203.107.180.114'),
(6926, 1290180467, 3, '203.107.180.114'),
(6927, 1290180467, 3, '122.168.84.94'),
(6928, 1290180467, 3, '124.253.44.15'),
(6929, 1290180467, 3, '113.162.87.90'),
(6930, 1290180467, 3, '67.21.68.3'),
(6931, 1290180467, 3, '115.189.249.178'),
(6932, 1290180467, 3, '67.21.69.175'),
(6933, 1290180467, 3, '124.253.44.85'),
(6934, 1290180467, 3, '217.170.97.242'),
(6935, 1290180467, 3, '121.229.138.87'),
(6936, 1290180467, 3, '67.21.69.145'),
(6937, 1290180467, 3, '67.21.69.145'),
(6938, 1290180467, 3, '67.99.190.246'),
(6939, 1290180467, 3, '203.87.202.190'),
(6940, 1290180467, 3, '91.212.226.246'),
(6941, 1290180467, 3, '213.5.69.42'),
(6942, 1290180467, 3, '67.21.68.19'),
(6943, 1290180467, 3, '67.21.68.19'),
(6944, 1290180467, 3, '120.28.197.138'),
(6945, 1290180467, 3, '75.173.254.193'),
(6946, 1290180467, 3, '117.242.224.47'),
(6947, 1290180467, 3, '97.121.182.194'),
(6948, 1290180467, 3, '61.247.243.92'),
(6949, 1290180467, 3, '72.229.122.71'),
(6950, 1290180467, 3, '204.120.17.186'),
(6951, 1290180467, 3, '115.187.16.1'),
(6952, 1290180467, 3, '74.115.160.156'),
(6953, 1290180467, 3, '206.248.156.197'),
(6954, 1290180467, 3, '112.198.64.52'),
(6955, 1290180467, 3, '68.234.11.79'),
(6956, 1290180467, 3, '94.43.115.159'),
(6957, 1290180467, 3, '63.223.112.220'),
(6958, 1290180467, 3, '112.133.206.20'),
(6959, 1290180467, 3, '86.172.233.9'),
(6960, 1290180467, 3, '91.214.128.23'),
(6961, 1290180467, 3, '117.241.104.46'),
(6962, 1290180467, 3, '92.82.231.116'),
(6963, 1290180467, 3, '112.202.24.197'),
(6964, 1290180467, 3, '86.177.11.31'),
(6965, 1290180467, 3, '117.200.178.150'),
(6966, 1290180467, 3, '58.27.152.224'),
(6967, 1290180467, 3, '180.180.85.70'),
(6968, 1290180467, 3, '68.168.219.55'),
(6969, 1290180467, 3, '98.126.125.210'),
(6970, 1290180467, 3, '188.92.75.148'),
(6971, 1290180467, 3, '80.130.251.147'),
(6972, 1290180467, 3, '64.71.141.150'),
(6973, 1290180467, 3, '180.190.161.173'),
(6974, 1290180467, 3, '174.34.144.211'),
(6975, 1290180467, 3, '203.92.52.138'),
(6976, 1290180467, 3, '113.88.26.219'),
(6977, 1290180467, 3, '121.54.2.85'),
(6978, 1290180467, 3, '81.43.168.237'),
(6979, 1290180467, 3, '87.69.188.237'),
(6980, 1290180467, 3, '116.25.19.125'),
(6981, 1290180467, 3, '117.200.178.61'),
(6982, 1290180467, 3, '188.92.75.148'),
(6983, 1290180467, 3, '202.70.51.99'),
(6984, 1290180467, 3, '124.182.243.15'),
(6985, 1290180467, 3, '83.189.81.54'),
(6986, 1290180467, 3, '64.38.198.61'),
(6987, 1290180467, 3, '97.121.176.86'),
(6988, 1290180467, 3, '113.168.248.206'),
(6989, 1290180467, 3, '41.190.16.17'),
(6990, 1290180467, 3, '121.96.158.125'),
(6991, 1290180467, 3, '68.195.156.190'),
(6992, 1290180467, 3, '94.159.187.165'),
(6993, 1290180467, 3, '74.63.253.11'),
(6994, 1290180467, 3, '173.208.71.18'),
(6995, 1290180467, 3, '202.91.8.222'),
(6996, 1290180467, 3, '118.137.83.97'),
(6997, 1290180467, 3, '119.42.81.9'),
(6998, 1290180467, 3, '124.82.81.82'),
(6999, 1290180467, 3, '180.234.142.20'),
(7000, 1290180467, 3, '90.62.29.147'),
(7001, 1290180467, 3, '112.200.17.213'),
(7002, 1290180467, 3, '96.49.194.226'),
(7003, 1290180467, 3, '24.148.3.229'),
(7004, 1290180467, 3, '173.208.71.18'),
(7005, 1290180467, 3, '77.125.89.181'),
(7006, 1290180467, 3, '68.68.108.3'),
(7007, 1290180467, 3, '115.127.11.155'),
(7008, 1290180467, 3, '117.241.83.249'),
(7009, 1290180467, 3, '61.93.13.139'),
(7010, 1290180467, 3, '124.6.181.122'),
(7011, 1290180467, 3, '91.212.226.246'),
(7012, 1290180467, 3, '123.236.139.81'),
(7013, 1290180467, 3, '119.153.136.34'),
(7014, 1290180467, 3, '64.20.45.130'),
(7015, 1290180467, 3, '67.21.69.130'),
(7016, 1290180467, 3, '85.176.162.93'),
(7017, 1290180467, 3, '218.248.49.149'),
(7018, 1290180467, 3, '76.30.231.187'),
(7019, 1290180467, 3, '212.235.107.7'),
(7020, 1290180467, 3, '94.142.131.190'),
(7021, 1290180467, 3, '69.22.184.10'),
(7022, 1290180467, 3, '59.164.18.50'),
(7023, 1290180467, 3, '174.34.133.211'),
(7024, 1290180467, 3, '86.14.205.6'),
(7025, 1290180467, 3, '151.20.255.84'),
(7026, 1290180467, 3, '89.146.86.154'),
(7027, 1290180467, 3, '82.6.128.188'),
(7028, 1290180467, 3, '217.169.214.221'),
(7029, 1290180467, 3, '112.198.245.72'),
(7030, 1290180467, 3, '86.0.254.209'),
(7031, 1290180467, 3, '78.2.119.10'),
(7032, 1290180467, 3, '86.23.32.99'),
(7033, 1290180467, 3, '112.202.106.93'),
(7034, 1290180467, 3, '79.114.251.150'),
(7035, 1290180467, 3, '78.2.119.10'),
(7036, 1290180467, 3, '124.253.44.47'),
(7037, 1290180467, 3, '124.179.108.112'),
(7038, 1290180467, 3, '125.162.221.23'),
(7039, 1290180467, 3, '113.162.87.130'),
(7040, 1290180467, 3, '68.234.11.35'),
(7041, 1290180467, 3, '213.5.69.42'),
(7042, 1290180467, 3, '211.138.124.202'),
(7043, 1290180467, 3, '125.160.96.150'),
(7044, 1290180467, 3, '109.153.203.96'),
(7045, 1290180467, 3, '218.248.84.93'),
(7046, 1290180467, 3, '76.121.147.48'),
(7047, 1290180467, 3, '124.253.45.3'),
(7048, 1290180467, 3, '41.234.159.127'),
(7049, 1290180467, 3, '99.34.25.241'),
(7050, 1290180467, 3, '64.62.196.39'),
(7051, 1290180467, 3, '180.190.164.45'),
(7052, 1290180467, 3, '24.22.136.38'),
(7053, 1290180467, 3, '111.125.68.130'),
(7054, 1290180467, 3, '82.22.155.224'),
(7055, 1290180467, 3, '61.247.243.65'),
(7056, 1290180467, 3, '119.30.38.43'),
(7057, 1290180467, 3, '208.43.170.185'),
(7058, 1290180467, 3, '202.7.218.52'),
(7059, 1290180467, 3, '122.162.18.168'),
(7060, 1290180467, 3, '122.164.116.236'),
(7061, 1290180467, 3, '66.32.78.189'),
(7062, 1290180467, 3, '69.180.28.38'),
(7063, 1290180467, 3, '87.57.124.126'),
(7064, 1290180467, 3, '173.73.164.183'),
(7065, 1290180467, 3, '66.71.244.29'),
(7066, 1290180467, 3, '88.156.8.215'),
(7067, 1290180467, 3, '76.27.205.231'),
(7068, 1290180467, 3, '95.134.116.150'),
(7069, 1290180467, 3, '27.54.10.253'),
(7070, 1290180467, 3, '77.93.27.72'),
(7071, 1290180467, 3, '124.106.150.235'),
(7072, 1290180467, 3, '84.62.220.93'),
(7073, 1290180467, 3, '27.54.10.253'),
(7074, 1290180467, 3, '208.101.140.5'),
(7075, 1290180467, 3, '180.190.179.105'),
(7076, 1290180467, 3, '119.153.49.188'),
(7077, 1290180467, 3, '67.212.185.82'),
(7078, 1290180467, 3, '122.144.113.229'),
(7079, 1290180467, 3, '68.234.11.86'),
(7080, 1290180467, 3, '67.21.68.10'),
(7081, 1290180467, 3, '76.30.231.187'),
(7082, 1290180467, 3, '202.148.56.74'),
(7083, 1290180467, 3, '203.92.52.157'),
(7084, 1290180467, 3, '67.21.65.250'),
(7085, 1290180467, 3, '216.93.191.241'),
(7086, 1290180467, 3, '173.35.100.224'),
(7087, 1290180467, 3, '79.117.244.27'),
(7088, 1290180467, 3, '122.163.126.210'),
(7089, 1290180467, 3, '204.188.200.17'),
(7090, 1290180467, 3, '122.161.14.190'),
(7091, 1290180467, 3, '62.221.107.204'),
(7092, 1290180467, 3, '61.141.91.220'),
(7093, 1290180467, 3, '120.28.241.100'),
(7094, 1290180467, 3, '60.217.248.133'),
(7095, 1290180467, 3, '112.202.11.169'),
(7096, 1290180467, 3, '213.5.67.157'),
(7097, 1290180467, 3, '92.37.44.0'),
(7098, 1290180467, 3, '222.165.133.198'),
(7099, 1290180467, 3, '61.247.243.174'),
(7100, 1290180467, 3, '125.60.235.211'),
(7101, 1290180467, 3, '117.242.224.60'),
(7102, 1290180467, 3, '97.121.187.192'),
(7103, 1290180467, 3, '115.189.194.103'),
(7104, 1290180467, 3, '117.200.183.62'),
(7105, 1290180467, 3, '68.234.11.3'),
(7106, 1290180467, 3, '122.168.69.196'),
(7107, 1290180467, 3, '115.118.145.7'),
(7108, 1290180467, 3, '120.28.220.142'),
(7109, 1290180467, 3, '75.187.80.159'),
(7110, 1290180467, 3, '110.138.212.157'),
(7111, 1290180467, 3, '97.121.178.227'),
(7112, 1290180467, 3, '119.30.39.53'),
(7113, 1290180467, 3, '193.198.184.5'),
(7114, 1290180467, 3, '124.125.41.227'),
(7115, 1290180467, 3, '85.24.86.162'),
(7116, 1290180467, 3, '112.198.241.248'),
(7117, 1290180467, 3, '75.171.97.47'),
(7118, 1290180467, 3, '203.45.158.233'),
(7119, 1290180467, 3, '69.112.181.15'),
(7120, 1290180467, 3, '95.29.193.214'),
(7121, 1290180467, 3, '98.206.217.194'),
(7122, 1290180467, 3, '98.206.217.194'),
(7123, 1290180467, 3, '173.234.178.31'),
(7124, 1290180467, 3, '114.79.55.18'),
(7125, 1290180467, 3, '75.72.149.47'),
(7126, 1290180467, 3, '203.223.95.178'),
(7127, 1290180467, 3, '68.234.11.254'),
(7128, 1290180467, 3, '68.149.97.143'),
(7129, 1290180467, 3, '65.78.36.97'),
(7130, 1290180467, 3, '122.163.96.199'),
(7131, 1290180467, 3, '87.68.219.89'),
(7132, 1290180467, 3, '80.130.206.4'),
(7133, 1290180467, 3, '71.52.34.139'),
(7134, 1290180467, 3, '112.202.48.23'),
(7135, 1290180467, 3, '91.212.226.41'),
(7136, 1290180467, 3, '201.196.239.82'),
(7137, 1290180467, 3, '69.162.152.47'),
(7138, 1290180467, 3, '75.187.80.159'),
(7139, 1290180467, 3, '72.8.155.186'),
(7140, 1290180467, 3, '68.2.227.198'),
(7141, 1290180467, 3, '69.112.180.60'),
(7142, 1290180467, 3, '91.201.66.85'),
(7143, 1290180467, 3, '95.41.204.163'),
(7144, 1290180467, 3, '218.186.8.234'),
(7145, 1290180467, 3, '78.84.140.29'),
(7146, 1290180467, 3, '67.250.16.57'),
(7147, 1290180467, 3, '200.216.54.230'),
(7148, 1290180467, 3, '123.27.105.126'),
(7149, 1290180467, 3, '68.234.11.127'),
(7150, 1290180467, 3, '78.99.174.221'),
(7151, 1290180467, 3, '122.178.129.176'),
(7152, 1290180467, 3, '122.161.84.176'),
(7153, 1290180467, 3, '125.24.40.174'),
(7154, 1290180467, 3, '112.198.64.45'),
(7155, 1290180467, 3, '208.98.45.74'),
(7156, 1290180467, 3, '173.218.230.14'),
(7157, 1290180467, 3, '95.103.240.163'),
(7158, 1290180467, 3, '124.182.243.15'),
(7159, 1290180467, 3, '115.189.239.253'),
(7160, 1290180467, 3, '75.173.254.143'),
(7161, 1290180467, 3, '208.98.55.95'),
(7162, 1290180467, 3, '59.98.169.18'),
(7163, 1290180467, 3, '218.81.89.27'),
(7164, 1290180467, 3, '68.68.106.151'),
(7165, 1290180467, 3, '92.83.159.99'),
(7166, 1290180467, 3, '67.23.122.236'),
(7167, 1290180467, 3, '208.98.45.54'),
(7168, 1290180467, 3, '59.98.169.47'),
(7169, 1290180467, 3, '121.97.174.249'),
(7170, 1290180467, 3, '76.25.12.221'),
(7171, 1290180467, 3, '86.182.131.88'),
(7172, 1290180467, 3, '95.88.169.171'),
(7173, 1290180467, 3, '121.54.2.167'),
(7174, 1290180467, 3, '122.168.70.50'),
(7175, 1290180467, 3, '115.252.101.147'),
(7176, 1290180467, 3, '208.88.120.87');
INSERT INTO `#__sl_SpamFilter` (`id`, `time`, `type`, `term`) VALUES
(7177, 1290180467, 3, '203.87.178.22'),
(7178, 1290180467, 3, '188.195.29.36'),
(7179, 1290180467, 3, '75.4.220.135'),
(7180, 1290180467, 3, '117.193.74.77'),
(7181, 1290180467, 3, '122.176.216.206'),
(7182, 1290180467, 3, '125.26.87.55'),
(7183, 1290180467, 3, '117.197.245.90'),
(7184, 1290180467, 3, '71.77.44.255'),
(7185, 1290180467, 3, '99.50.205.83'),
(7186, 1290180467, 3, '122.168.230.255'),
(7187, 1290180467, 3, '74.115.160.206'),
(7188, 1290180467, 3, '58.23.22.73'),
(7189, 1290180467, 3, '122.166.65.228'),
(7190, 1290180467, 3, '203.206.232.181'),
(7191, 1290180467, 3, '84.110.199.242'),
(7192, 1290180467, 3, '88.229.147.40'),
(7193, 1290180467, 3, '70.107.131.96'),
(7194, 1290180467, 3, '142.68.143.70'),
(7195, 1290180467, 3, '85.227.152.87'),
(7196, 1290180467, 3, '173.234.30.9'),
(7197, 1290180467, 3, '99.30.65.41'),
(7198, 1290180467, 3, '76.18.0.105'),
(7199, 1290180467, 3, '75.58.144.81'),
(7200, 1290180467, 3, '92.86.130.2'),
(7201, 1290180467, 3, '92.15.240.135'),
(7202, 1290180467, 3, '200.115.209.181'),
(7203, 1290180467, 3, '69.244.197.157'),
(7204, 1290180467, 3, '90.206.85.92'),
(7205, 1290180467, 3, '71.142.58.47'),
(7206, 1290180467, 3, '67.77.187.123'),
(7207, 1290180467, 3, '87.68.229.213'),
(7208, 1290180467, 3, '62.108.24.102'),
(7209, 1290180467, 3, '79.117.244.54'),
(7210, 1290180467, 3, '58.27.219.91'),
(7211, 1290180467, 3, '125.164.134.176'),
(7212, 1290180467, 3, '119.155.99.255'),
(7213, 1290180467, 3, '76.66.172.19'),
(7214, 1290180467, 3, '89.238.173.204'),
(7215, 1290180467, 3, '216.55.165.108'),
(7216, 1290180467, 3, '66.176.151.37'),
(7217, 1290180467, 3, '210.4.13.218'),
(7218, 1290180467, 3, '112.202.110.221'),
(7219, 1290180467, 3, '90.24.152.49'),
(7220, 1290180467, 3, '69.162.143.105'),
(7221, 1290180467, 3, '84.61.140.218'),
(7222, 1290180467, 3, '123.236.140.182'),
(7223, 1290180467, 3, '58.152.171.138'),
(7224, 1290180467, 3, '213.0.89.7'),
(7225, 1290180467, 3, '91.201.66.85'),
(7226, 1290180467, 3, '86.134.216.202'),
(7227, 1290180467, 3, '147.91.1.41'),
(7228, 1290180467, 3, '195.216.197.115'),
(7229, 1290180467, 3, '67.202.89.3'),
(7230, 1290180467, 3, '218.79.91.8'),
(7231, 1290180467, 3, '188.92.75.148'),
(7232, 1290180467, 3, '90.219.132.57'),
(7233, 1290180467, 3, '117.242.224.96'),
(7234, 1290180467, 3, '115.118.250.223'),
(7235, 1290180467, 3, '125.24.73.61'),
(7236, 1290180467, 3, '79.117.230.243'),
(7237, 1290180467, 3, '77.78.103.215'),
(7238, 1290180467, 3, '217.23.14.149'),
(7239, 1290180467, 3, '203.92.52.149'),
(7240, 1290180467, 3, '117.196.239.77'),
(7241, 1290180467, 3, '91.105.61.229'),
(7242, 1290180467, 3, '113.168.254.46'),
(7243, 1290180467, 3, '58.27.166.159'),
(7244, 1290180467, 3, '118.137.111.130'),
(7245, 1290180467, 3, '90.185.167.116'),
(7246, 1290180467, 3, '208.98.45.64'),
(7247, 1290180467, 3, '124.253.45.99'),
(7248, 1290180467, 3, '116.74.113.241'),
(7249, 1290180467, 3, '125.164.140.166'),
(7250, 1290180467, 3, '124.125.43.2'),
(7251, 1290180467, 3, '110.139.28.117'),
(7252, 1290180467, 3, '113.193.27.74'),
(7253, 1290180467, 3, '112.198.64.39'),
(7254, 1290180467, 3, '121.54.2.167'),
(7255, 1290180467, 3, '173.183.235.125'),
(7256, 1290180467, 3, '69.180.161.192'),
(7257, 1290180467, 3, '173.234.44.97'),
(7258, 1290180467, 3, '202.70.59.73'),
(7259, 1290180467, 3, '112.202.24.37'),
(7260, 1290180467, 3, '99.144.83.150'),
(7261, 1290180467, 3, '122.177.113.21'),
(7262, 1290180467, 3, '61.247.243.140'),
(7263, 1290180467, 3, '67.21.69.182'),
(7264, 1290180467, 3, '90.194.111.235'),
(7265, 1290180467, 3, '173.234.46.186'),
(7266, 1290180467, 3, '174.30.139.155'),
(7267, 1290180467, 3, '68.234.11.54'),
(7268, 1290180467, 3, '89.123.109.229'),
(7269, 1290180467, 3, '72.201.89.15'),
(7270, 1290180467, 3, '71.14.120.84'),
(7271, 1290180467, 3, '59.103.222.91'),
(7272, 1290180467, 3, '70.32.33.163'),
(7273, 1290180467, 3, '121.97.112.58'),
(7274, 1290180467, 3, '122.55.12.153'),
(7275, 1290180467, 3, '67.21.68.18'),
(7276, 1290180467, 3, '203.87.178.16'),
(7277, 1290180467, 3, '75.212.109.76'),
(7278, 1290180467, 3, '97.118.243.7'),
(7279, 1290180467, 3, '97.112.184.90'),
(7280, 1290180467, 3, '77.208.57.23'),
(7281, 1290180467, 3, '112.202.10.76'),
(7282, 1290180467, 3, '67.21.69.190'),
(7283, 1290180467, 3, '67.21.69.190'),
(7284, 1290180467, 3, '72.218.22.152'),
(7285, 1290180467, 3, '24.102.226.44'),
(7286, 1290180467, 3, '69.162.143.105'),
(7287, 1290180467, 3, '90.194.111.235'),
(7288, 1290180467, 3, '173.183.235.125'),
(7289, 1290180467, 3, '219.133.34.110'),
(7290, 1290180467, 3, '188.92.75.148'),
(7291, 1290180467, 3, '60.217.232.73'),
(7292, 1290180467, 3, '115.132.30.139'),
(7293, 1290180467, 3, '112.202.92.113'),
(7294, 1290180467, 3, '188.220.83.252'),
(7295, 1290180467, 3, '121.97.174.191'),
(7296, 1290180467, 3, '92.21.151.105'),
(7297, 1290180467, 3, '115.240.120.135'),
(7298, 1290180467, 3, '117.200.177.176'),
(7299, 1290180467, 3, '74.82.24.119'),
(7300, 1290180467, 3, '81.136.234.1'),
(7301, 1290180467, 3, '86.21.141.214'),
(7302, 1290180467, 3, '121.215.170.88'),
(7303, 1290180467, 3, '115.133.219.26'),
(7304, 1290180467, 3, '85.165.157.189'),
(7305, 1290180467, 3, '203.87.178.21'),
(7306, 1290180467, 3, '124.6.181.164'),
(7307, 1290180467, 3, '63.223.112.79'),
(7308, 1290180467, 3, '121.31.43.113'),
(7309, 1290180467, 3, '122.177.63.254'),
(7310, 1290180467, 3, '12.198.124.226'),
(7311, 1290180467, 3, '64.120.86.253'),
(7312, 1290180467, 3, '124.43.9.194'),
(7313, 1290180467, 3, '117.242.108.235'),
(7314, 1290180467, 3, '118.70.132.64'),
(7315, 1290180467, 3, '64.17.82.240'),
(7316, 1290180467, 3, '119.157.75.177'),
(7317, 1290180467, 3, '115.167.51.57'),
(7318, 1290180467, 3, '68.234.11.148'),
(7319, 1290180467, 3, '121.97.103.239'),
(7320, 1290180467, 3, '67.21.68.28'),
(7321, 1290180467, 3, '77.93.2.81'),
(7322, 1290180467, 3, '178.33.6.169'),
(7323, 1290180467, 3, '91.201.66.85'),
(7324, 1290180467, 3, '60.217.232.52'),
(7325, 1290180467, 3, '95.220.76.243'),
(7326, 1290180467, 3, '66.71.244.28'),
(7327, 1290180467, 3, '122.161.167.221'),
(7328, 1290180467, 3, '115.127.9.146'),
(7329, 1290180467, 3, '68.234.20.140'),
(7330, 1290180467, 3, '69.147.240.122'),
(7331, 1290180467, 3, '217.174.60.119'),
(7332, 1290180467, 3, '95.68.65.167'),
(7333, 1290180467, 3, '61.247.243.71'),
(7334, 1290180467, 3, '109.182.50.190'),
(7335, 1290180467, 3, '76.105.40.101'),
(7336, 1290180467, 3, '116.71.47.26'),
(7337, 1290180467, 3, '182.2.210.124'),
(7338, 1290180467, 3, '117.242.224.28'),
(7339, 1290180467, 3, '80.77.63.58'),
(7340, 1290180467, 3, '188.126.70.184'),
(7341, 1290180467, 3, '70.118.94.248'),
(7342, 1290180467, 3, '72.35.103.185'),
(7343, 1290180467, 3, '112.202.105.211'),
(7344, 1290180467, 3, '84.61.39.168'),
(7345, 1290180467, 3, '66.71.244.26'),
(7346, 1290180467, 3, '92.36.148.131'),
(7347, 1290180467, 3, '112.198.64.1'),
(7348, 1290180467, 3, '63.223.112.164'),
(7349, 1290180467, 3, '63.223.112.55'),
(7350, 1290180467, 3, '124.126.133.18'),
(7351, 1290180467, 3, '110.55.165.150'),
(7352, 1290180467, 3, '122.178.162.127'),
(7353, 1290180467, 3, '80.91.180.30'),
(7354, 1290180467, 3, '72.8.191.243'),
(7355, 1290180467, 3, '111.92.80.128'),
(7356, 1290180467, 3, '112.202.105.211'),
(7357, 1290180467, 3, '173.20.169.63'),
(7358, 1290180467, 3, '117.242.108.103'),
(7359, 1290180467, 3, '74.5.65.48'),
(7360, 1290180467, 3, '99.243.228.82'),
(7361, 1290180467, 3, '174.34.133.219'),
(7362, 1290180467, 3, '124.6.181.118'),
(7363, 1290180467, 3, '98.142.212.59'),
(7364, 1290180467, 3, '121.97.112.57'),
(7365, 1290180467, 3, '63.223.112.68'),
(7366, 1290180467, 3, '98.142.212.83'),
(7367, 1290180467, 3, '68.200.209.236'),
(7368, 1290180467, 3, '122.162.121.248'),
(7369, 1290180467, 3, '117.242.224.59'),
(7370, 1290180467, 3, '122.169.127.242'),
(7371, 1290180467, 3, '119.92.184.108'),
(7372, 1290180467, 3, '122.52.119.206'),
(7373, 1290180467, 3, '121.54.68.182'),
(7374, 1290180467, 3, '120.40.128.78'),
(7375, 1290180467, 3, '221.206.101.210'),
(7376, 1290180467, 3, '65.35.24.53'),
(7377, 1290180467, 3, '123.68.86.176'),
(7378, 1290180467, 3, '58.27.204.18'),
(7379, 1290180467, 3, '203.87.178.20'),
(7380, 1290180467, 3, '208.98.55.86'),
(7381, 1290180467, 3, '208.98.19.48'),
(7382, 1290180467, 3, '92.85.36.185'),
(7383, 1290180467, 3, '208.98.19.16'),
(7384, 1290180467, 3, '208.98.45.126'),
(7385, 1290180467, 3, '70.138.79.30'),
(7386, 1290180467, 3, '67.21.65.213'),
(7387, 1290180467, 3, '208.98.45.49'),
(7388, 1290180467, 3, '91.201.66.31'),
(7389, 1290180467, 3, '91.214.128.24'),
(7390, 1290180467, 3, '174.34.144.147'),
(7391, 1290180467, 3, '79.119.179.22'),
(7392, 1290180467, 3, '123.237.96.53'),
(7393, 1290180467, 3, '66.71.244.30'),
(7394, 1290180467, 3, '124.6.181.163'),
(7395, 1290180467, 3, '69.162.152.36'),
(7396, 1290180467, 3, '124.6.181.163'),
(7397, 1290180467, 3, '81.99.65.58'),
(7398, 1290180467, 3, '94.4.44.190'),
(7399, 1290180467, 3, '99.229.97.159'),
(7400, 1290180467, 3, '173.208.96.180'),
(7401, 1290180467, 3, '122.172.212.110'),
(7402, 1290180467, 3, '98.142.212.2'),
(7403, 1290180467, 3, '98.254.114.61'),
(7404, 1290180467, 3, '120.28.211.180'),
(7405, 1290180467, 3, '98.142.212.157'),
(7406, 1290180467, 3, '80.251.113.35'),
(7407, 1290180467, 3, '178.33.6.169'),
(7408, 1290180467, 3, '87.194.242.43'),
(7409, 1290180467, 3, '80.130.186.8'),
(7410, 1290180467, 3, '82.192.62.216'),
(7411, 1290180467, 3, '78.227.34.111'),
(7412, 1290180467, 3, '93.63.71.211'),
(7413, 1290180467, 3, '120.28.211.10'),
(7414, 1290180467, 3, '76.101.69.243'),
(7415, 1290180467, 3, '209.107.217.122'),
(7416, 1290180467, 3, '117.196.243.24'),
(7417, 1290180467, 3, '208.98.19.62'),
(7418, 1290180467, 3, '76.101.69.243'),
(7419, 1290180467, 3, '112.204.52.207'),
(7420, 1290180467, 3, '99.229.97.159'),
(7421, 1290180467, 3, '207.58.217.28'),
(7422, 1290180467, 3, '24.115.33.145'),
(7423, 1290180467, 3, '208.66.19.129'),
(7424, 1290180467, 3, '113.193.30.210'),
(7425, 1290180467, 3, '74.58.43.218'),
(7426, 1290180467, 3, '208.98.19.111'),
(7427, 1290180467, 3, '211.138.124.202'),
(7428, 1290180467, 3, '216.93.191.251'),
(7429, 1290180467, 3, '189.147.81.82'),
(7430, 1290180467, 3, '208.101.128.106'),
(7431, 1290180467, 3, '115.187.43.154'),
(7432, 1290180467, 3, '99.176.9.81'),
(7433, 1290180467, 3, '117.204.104.158'),
(7434, 1290180467, 3, '70.119.78.182'),
(7435, 1290180467, 3, '174.34.144.211'),
(7436, 1290180467, 3, '63.223.112.11'),
(7437, 1290180467, 3, '112.202.15.134'),
(7438, 1290180467, 3, '117.242.108.235'),
(7439, 1290180467, 3, '110.55.165.150'),
(7440, 1290180467, 3, '113.168.241.36'),
(7441, 1290180467, 3, '87.127.159.28'),
(7442, 1290180467, 3, '122.168.244.160'),
(7443, 1290180467, 3, '77.180.12.245'),
(7444, 1290180467, 3, '68.234.11.54'),
(7445, 1290180467, 3, '68.234.11.134'),
(7446, 1290180467, 3, '208.98.19.38'),
(7447, 1290180467, 3, '78.33.200.215'),
(7448, 1290180467, 3, '123.116.149.161'),
(7449, 1290180467, 3, '92.15.254.18'),
(7450, 1290180467, 3, '113.170.241.151'),
(7451, 1290180467, 3, '68.234.11.226'),
(7452, 1290180467, 3, '68.39.243.202'),
(7453, 1290180467, 3, '109.96.72.21'),
(7454, 1290180467, 3, '151.213.195.205'),
(7455, 1290180467, 3, '63.223.112.248'),
(7456, 1290180467, 3, '204.188.215.78'),
(7457, 1290180467, 3, '196.210.137.167'),
(7458, 1290180467, 3, '125.24.52.15'),
(7459, 1290180467, 3, '68.234.11.160'),
(7460, 1290180467, 3, '208.98.19.59'),
(7461, 1290180467, 3, '24.22.161.172'),
(7462, 1290180467, 3, '98.85.35.176'),
(7463, 1290180467, 3, '97.112.176.180'),
(7464, 1290180467, 3, '121.214.98.140'),
(7465, 1290180467, 3, '72.8.165.222'),
(7466, 1290180467, 3, '63.223.112.254'),
(7467, 1290180467, 3, '98.142.212.112'),
(7468, 1290180467, 3, '113.162.87.108'),
(7469, 1290180467, 3, '122.164.240.111'),
(7470, 1290180467, 3, '63.223.112.20'),
(7471, 1290180467, 3, '208.98.55.13'),
(7472, 1290180467, 3, '61.247.44.176'),
(7473, 1290180467, 3, '63.223.112.220'),
(7474, 1290180467, 3, '208.98.45.43'),
(7475, 1290180467, 3, '125.60.252.171'),
(7476, 1290180467, 3, '61.247.243.83'),
(7477, 1290180467, 3, '68.168.215.133'),
(7478, 1290180467, 3, '91.135.102.193'),
(7479, 1290180467, 3, '58.27.151.185'),
(7480, 1290180467, 3, '118.100.216.154'),
(7481, 1290180467, 3, '97.112.144.111'),
(7482, 1290180467, 3, '209.222.3.20'),
(7483, 1290180467, 3, '180.129.1.20'),
(7484, 1290180467, 3, '121.96.136.42'),
(7485, 1290180467, 3, '98.142.212.164'),
(7486, 1290180467, 3, '98.142.212.126'),
(7487, 1290180467, 3, '63.223.112.38'),
(7488, 1290180467, 3, '68.234.11.156'),
(7489, 1290180467, 3, '81.94.199.241'),
(7490, 1290180467, 3, '84.188.223.58'),
(7491, 1290180467, 3, '67.247.134.207'),
(7492, 1290180467, 3, '92.82.50.28'),
(7493, 1290180467, 3, '112.202.3.100'),
(7494, 1290180467, 3, '92.15.247.217'),
(7495, 1290180467, 3, '64.120.55.155'),
(7496, 1290180467, 3, '88.234.241.32'),
(7497, 1290180467, 3, '79.231.71.175'),
(7498, 1290180467, 3, '115.87.65.231'),
(7499, 1290180467, 3, '24.6.181.162'),
(7500, 1290180467, 3, '69.197.15.142'),
(7501, 1290180467, 3, '208.98.19.81'),
(7502, 1290180467, 3, '68.234.11.226'),
(7503, 1290180467, 3, '71.131.128.8'),
(7504, 1290180467, 3, '69.197.15.187'),
(7505, 1290180467, 3, '203.92.52.152'),
(7506, 1290180467, 3, '208.98.19.101'),
(7507, 1290180467, 3, '58.27.156.187'),
(7508, 1290180467, 3, '68.234.11.226'),
(7509, 1290180467, 3, '112.206.52.59'),
(7510, 1290180467, 3, '208.98.19.64'),
(7511, 1290180467, 3, '120.28.232.246'),
(7512, 1290180467, 3, '99.95.42.226'),
(7513, 1290180467, 3, '92.15.247.217'),
(7514, 1290180467, 3, '92.82.58.87'),
(7515, 1290180467, 3, '68.234.11.22'),
(7516, 1290180467, 3, '63.223.112.92'),
(7517, 1290180467, 3, '99.30.229.234'),
(7518, 1290180467, 3, '69.147.242.155'),
(7519, 1290180467, 3, '69.29.195.204'),
(7520, 1290180467, 3, '173.234.175.148'),
(7521, 1290180467, 3, '173.144.119.125'),
(7522, 1290180467, 3, '68.39.243.202'),
(7523, 1290180467, 3, '120.28.226.82'),
(7524, 1290180467, 3, '67.247.134.207'),
(7525, 1290180467, 3, '69.120.62.65'),
(7526, 1290180467, 3, '64.69.33.93'),
(7527, 1290180467, 3, '202.70.59.247'),
(7528, 1290180467, 3, '41.212.25.176'),
(7529, 1290180467, 3, '120.28.248.43'),
(7530, 1290180467, 3, '121.54.83.195'),
(7531, 1290180467, 3, '180.180.174.26'),
(7532, 1290180467, 3, '119.153.109.98'),
(7533, 1290180467, 3, '122.168.30.204'),
(7534, 1290180467, 3, '24.22.161.172'),
(7535, 1290180467, 3, '59.95.162.106'),
(7536, 1290180467, 3, '67.247.134.207'),
(7537, 1290180467, 3, '208.98.45.51'),
(7538, 1290180467, 3, '202.70.59.112'),
(7539, 1290180467, 3, '124.6.181.174'),
(7540, 1290180467, 3, '85.176.164.111'),
(7541, 1290180467, 3, '173.224.217.10'),
(7542, 1290180467, 3, '63.223.112.12'),
(7543, 1290180467, 3, '95.149.72.201'),
(7544, 1290180467, 3, '75.119.230.154'),
(7545, 1290180467, 3, '173.224.217.10'),
(7546, 1290180467, 3, '69.120.62.65'),
(7547, 1290180467, 3, '209.222.3.15'),
(7548, 1290180467, 3, '68.234.11.156'),
(7549, 1290180467, 3, '208.98.19.45'),
(7550, 1290180467, 3, '99.225.188.172'),
(7551, 1290180467, 3, '124.6.181.117'),
(7552, 1290180467, 3, '190.134.16.170'),
(7553, 1290180467, 3, '113.162.87.15'),
(7554, 1290180467, 3, '118.137.197.167'),
(7555, 1290180467, 3, '97.112.176.134'),
(7556, 1290180467, 3, '63.223.112.254'),
(7557, 1290180467, 3, '63.223.112.44'),
(7558, 1290180467, 3, '86.31.172.187'),
(7559, 1290180467, 3, '112.202.40.225'),
(7560, 1290180467, 3, '98.251.115.142'),
(7561, 1290180467, 3, '63.223.112.141'),
(7562, 1290180467, 3, '98.142.212.96'),
(7563, 1290180467, 3, '68.234.11.241'),
(7564, 1290180467, 3, '68.108.150.59'),
(7565, 1290180467, 3, '66.154.116.91'),
(7566, 1290180467, 3, '125.160.144.113'),
(7567, 1290180467, 3, '94.200.43.132'),
(7568, 1290180467, 3, '173.234.30.58'),
(7569, 1290180467, 3, '95.26.136.65'),
(7570, 1290180467, 3, '204.152.219.11'),
(7571, 1290180467, 3, '125.211.216.230'),
(7572, 1290180467, 3, '93.174.95.161'),
(7573, 1290180467, 3, '109.232.57.35'),
(7574, 1290180467, 3, '203.98.116.187'),
(7575, 1290180467, 3, '121.123.203.149'),
(7576, 1290180467, 3, '207.195.244.187'),
(7577, 1290180467, 3, '1.23.71.247'),
(7578, 1290180467, 3, '123.49.21.89'),
(7579, 1290180467, 3, '122.168.200.76'),
(7580, 1290180467, 3, '76.169.137.0'),
(7581, 1290180467, 3, '180.190.153.229'),
(7582, 1290180467, 3, '1.23.74.210'),
(7583, 1290180467, 3, '122.163.111.6'),
(7584, 1290180467, 3, '117.200.188.31'),
(7585, 1290180467, 3, '93.189.89.119'),
(7586, 1290180467, 3, '83.27.116.109'),
(7587, 1290180467, 3, '173.208.46.212'),
(7588, 1290180467, 3, '173.234.248.198'),
(7589, 1290180467, 3, '173.234.248.198'),
(7590, 1290180467, 3, '173.234.250.176'),
(7591, 1290180467, 3, '173.208.43.59'),
(7592, 1290180467, 3, '173.208.43.59'),
(7593, 1290180467, 3, '122.163.39.183'),
(7594, 1290180467, 3, '117.197.249.41'),
(7595, 1290180467, 3, '112.198.209.8'),
(7596, 1290180467, 3, '72.8.165.216'),
(7597, 1290180467, 3, '209.107.217.102'),
(7598, 1290180467, 3, '65.184.144.145'),
(7599, 1290180467, 3, '180.190.149.239'),
(7600, 1290180467, 3, '117.196.226.175'),
(7601, 1290180467, 3, '95.79.69.70'),
(7602, 1290180467, 3, '204.152.219.11'),
(7603, 1290180467, 3, '95.86.244.16'),
(7604, 1290180467, 3, '118.96.33.34'),
(7605, 1290180467, 3, '95.79.69.70'),
(7606, 1290180467, 3, '67.159.3.203'),
(7607, 1290180467, 3, '41.196.77.241'),
(7608, 1290180467, 3, '175.110.16.249'),
(7609, 1290180467, 3, '173.234.31.39'),
(7610, 1290180467, 3, '113.166.13.196'),
(7611, 1290180467, 3, '119.153.137.114'),
(7612, 1290180467, 3, '89.36.151.97'),
(7613, 1290180467, 3, '119.155.19.145'),
(7614, 1290180467, 3, '117.196.235.255'),
(7615, 1290180467, 3, '95.79.109.48'),
(7616, 1290180467, 3, '83.9.21.56'),
(7617, 1290180467, 3, '83.9.21.56'),
(7618, 1290180467, 3, '112.203.12.221'),
(7619, 1290180467, 3, '89.178.182.107'),
(7620, 1290180467, 3, '75.15.185.234'),
(7621, 1290180467, 3, '212.110.182.170'),
(7622, 1290180467, 3, '180.190.154.102'),
(7623, 1290180467, 3, '173.234.234.17'),
(7624, 1290180467, 3, '80.174.232.145'),
(7625, 1290180467, 3, '89.46.111.83'),
(7626, 1290180467, 3, '124.6.181.112'),
(7627, 1290180467, 3, '95.26.207.87'),
(7628, 1290180467, 3, '122.169.18.87'),
(7629, 1290180467, 3, '85.177.165.1'),
(7630, 1290180467, 3, '87.114.25.15'),
(7631, 1290180467, 3, '122.173.168.117'),
(7632, 1290180467, 3, '220.233.48.247'),
(7633, 1290180467, 3, '86.180.213.143'),
(7634, 1290180467, 3, '180.234.36.189'),
(7635, 1290180467, 3, '203.73.85.44'),
(7636, 1290180467, 3, '125.212.86.64'),
(7637, 1290180467, 3, '173.208.125.217'),
(7638, 1290180467, 3, '120.28.228.114'),
(7639, 1290180467, 3, '112.201.228.86'),
(7640, 1290180467, 3, '120.28.222.91'),
(7641, 1290180467, 3, '99.253.203.192'),
(7642, 1290180467, 3, '75.108.248.182'),
(7643, 1290180467, 3, '77.37.179.227'),
(7644, 1290180467, 3, '64.110.199.234'),
(7645, 1290180467, 3, '116.71.163.102'),
(7646, 1290180467, 3, '202.70.54.186'),
(7647, 1290180467, 3, '173.245.64.52'),
(7648, 1290180467, 3, '95.27.236.223'),
(7649, 1290180467, 3, '122.174.184.142'),
(7650, 1290180467, 3, '118.71.182.125'),
(7651, 1290180467, 3, '119.30.38.52'),
(7652, 1290180467, 3, '58.27.168.247'),
(7653, 1290180467, 3, '123.49.20.150'),
(7654, 1290180467, 3, '76.247.106.114'),
(7655, 1290180467, 3, '122.177.0.173'),
(7656, 1290180467, 3, '87.68.242.148'),
(7657, 1290180467, 3, '170.252.47.25'),
(7658, 1290180467, 3, '112.201.85.19'),
(7659, 1290180467, 3, '174.1.197.52'),
(7660, 1290180467, 3, '71.97.69.235'),
(7661, 1290180467, 3, '68.199.135.215'),
(7662, 1290180467, 3, '113.162.87.61'),
(7663, 1290180467, 3, '87.64.50.218'),
(7664, 1290180467, 3, '121.54.2.152'),
(7665, 1290180467, 3, '122.168.75.121'),
(7666, 1290180467, 3, '95.26.173.139'),
(7667, 1290180467, 3, '61.184.205.58'),
(7668, 1290180467, 3, '113.162.87.47'),
(7669, 1290180467, 3, '95.26.167.205'),
(7670, 1290180467, 3, '79.176.202.170'),
(7671, 1290180467, 3, '113.162.87.192'),
(7672, 1290180467, 3, '95.27.155.149'),
(7673, 1290180467, 3, '114.130.35.114'),
(7674, 1290180467, 3, '1.23.75.207'),
(7675, 1290180467, 3, '221.7.245.166'),
(7676, 1290180467, 3, '182.2.174.43'),
(7677, 1290180467, 3, '221.206.112.16'),
(7678, 1290180467, 3, '93.80.108.154'),
(7679, 1290180467, 3, '86.57.142.31'),
(7680, 1290180467, 3, '118.101.96.8'),
(7681, 1290180467, 3, '201.253.187.82'),
(7682, 1290180467, 3, '78.106.72.157'),
(7683, 1290180467, 3, '117.202.137.85'),
(7684, 1290180467, 3, '113.166.134.114'),
(7685, 1290180467, 3, '216.169.110.206'),
(7686, 1290180467, 3, '222.123.124.161'),
(7687, 1290180467, 3, '117.195.212.76'),
(7688, 1290180467, 3, '95.27.59.72'),
(7689, 1290180467, 3, '118.70.168.35'),
(7690, 1290180467, 3, '112.205.107.109'),
(7691, 1290180467, 3, '122.49.151.216'),
(7692, 1290180467, 3, '134.121.86.2'),
(7693, 1290180467, 3, '98.143.144.123'),
(7694, 1290180467, 3, '95.26.152.253'),
(7695, 1290180467, 3, '114.130.35.114'),
(7696, 1290180467, 3, '121.247.225.46'),
(7697, 1290180467, 3, '173.234.94.114'),
(7698, 1290180467, 3, '205.217.228.178'),
(7699, 1290180467, 3, '67.166.255.171'),
(7700, 1290180467, 3, '125.60.217.75'),
(7701, 1290180467, 3, '180.215.186.36'),
(7702, 1290180467, 3, '95.25.40.105'),
(7703, 1290180467, 3, '78.86.88.14'),
(7704, 1290180467, 3, '95.178.193.179'),
(7705, 1290180467, 3, '87.97.145.41'),
(7706, 1290180467, 3, '90.196.98.89'),
(7707, 1290180467, 3, '95.27.47.105'),
(7708, 1290180467, 3, '173.234.250.254'),
(7709, 1290180467, 3, '125.83.60.173'),
(7710, 1290180467, 3, '95.24.184.23'),
(7711, 1290180467, 3, '115.135.12.112'),
(7712, 1290180467, 3, '111.125.229.57'),
(7713, 1290180467, 3, '173.234.122.86'),
(7714, 1290180467, 3, '59.161.91.182'),
(7715, 1290180467, 3, '122.163.39.156'),
(7716, 1290180467, 3, '108.14.226.43'),
(7717, 1290180467, 3, '95.25.67.44'),
(7718, 1290180467, 3, '85.140.0.8'),
(7719, 1290180467, 3, '82.81.3.165'),
(7720, 1290180467, 3, '80.65.244.186'),
(7721, 1290180467, 3, '94.100.17.56'),
(7722, 1290180467, 3, '175.138.67.81'),
(7723, 1290180467, 3, '76.254.158.53'),
(7724, 1290180467, 3, '95.25.18.5'),
(7725, 1290180467, 3, '123.236.171.2'),
(7726, 1290180467, 3, '98.231.165.152'),
(7727, 1290180467, 3, '88.73.198.76'),
(7728, 1290180467, 3, '59.94.142.154'),
(7729, 1290180467, 3, '203.73.248.49'),
(7730, 1290180467, 3, '203.177.201.101'),
(7731, 1290180467, 3, '96.9.148.216'),
(7732, 1290180467, 3, '123.125.156.207'),
(7733, 1290180467, 3, '209.107.217.194'),
(7734, 1290180467, 3, '180.190.147.5'),
(7735, 1290180467, 3, '98.193.1.133'),
(7736, 1290180467, 3, '59.96.25.124'),
(7737, 1290180467, 3, '180.190.147.5'),
(7738, 1290180467, 3, '97.107.142.93'),
(7739, 1290180467, 3, '117.196.226.238'),
(7740, 1290180467, 3, '76.210.42.137'),
(7741, 1290180467, 3, '122.168.240.12'),
(7742, 1290180467, 3, '69.22.184.72'),
(7743, 1290180467, 3, '189.225.72.199'),
(7744, 1290180467, 3, '96.9.148.214'),
(7745, 1290180467, 3, '67.214.168.160'),
(7746, 1290180467, 3, '67.214.168.155'),
(7747, 1290180467, 3, '125.165.28.225'),
(7748, 1290180467, 3, '79.111.204.221'),
(7749, 1290180467, 3, '125.165.28.225'),
(7750, 1290180467, 3, '198.137.215.7'),
(7751, 1290180467, 3, '66.232.112.177'),
(7752, 1290180467, 3, '123.236.3.104'),
(7753, 1290180467, 3, '67.49.176.100'),
(7754, 1290180467, 3, '203.109.71.154'),
(7755, 1290180467, 3, '180.191.42.210'),
(7756, 1290180467, 3, '178.22.192.103'),
(7757, 1290180467, 3, '59.92.115.185'),
(7758, 1290180467, 3, '116.71.33.202'),
(7759, 1290180467, 3, '74.82.24.114'),
(7760, 1290180467, 3, '173.245.64.116'),
(7761, 1290180467, 3, '72.8.165.107'),
(7762, 1290180467, 3, '120.56.137.207'),
(7763, 1290180467, 3, '120.40.144.147'),
(7764, 1290180467, 3, '67.76.217.16'),
(7765, 1290180467, 3, '92.101.155.53'),
(7766, 1290180467, 3, '114.39.91.74'),
(7767, 1290180467, 3, '116.22.53.198'),
(7768, 1290180467, 3, '80.67.13.197'),
(7769, 1290180467, 3, '79.191.253.119'),
(7770, 1290180467, 3, '208.43.251.63'),
(7771, 1290180467, 3, '82.230.106.84'),
(7772, 1290180467, 3, '95.178.200.195'),
(7773, 1290180467, 3, '216.218.211.221'),
(7774, 1290180467, 3, '130.94.133.108'),
(7775, 1290180467, 3, '173.17.12.229'),
(7776, 1290180467, 3, '125.31.50.138'),
(7777, 1290180467, 3, '86.28.185.216'),
(7778, 1290180467, 3, '95.79.100.173'),
(7779, 1290180467, 3, '95.26.176.254'),
(7780, 1290180467, 3, '92.50.178.162'),
(7781, 1290180467, 3, '193.28.239.1'),
(7782, 1290180467, 3, '174.133.147.243'),
(7783, 1290180467, 3, '83.218.63.63'),
(7784, 1290180467, 3, '88.247.84.138'),
(7785, 1290180467, 3, '88.1.121.242'),
(7786, 1290180467, 3, '221.238.122.82'),
(7787, 1290180467, 3, '198.236.0.34'),
(7788, 1290180467, 3, '208.113.193.12'),
(7789, 1290180467, 3, '200.150.68.78'),
(7790, 1290180467, 3, '112.207.239.227'),
(7791, 1290180467, 3, '219.153.150.101'),
(7792, 1290180467, 3, '147.91.71.30'),
(7793, 1290180467, 3, '173.203.82.76'),
(7794, 1290180467, 3, '213.230.23.101'),
(7795, 1290180467, 3, '222.220.44.210'),
(7796, 1290180467, 3, '120.42.20.202'),
(7797, 1290180467, 3, '95.26.176.77'),
(7798, 1290180467, 3, '110.138.81.55'),
(7799, 1290180467, 3, '113.109.190.103'),
(7800, 1290180467, 3, '115.150.218.210'),
(7801, 1290180467, 3, '82.207.44.116'),
(7802, 1290180467, 3, '76.127.95.12'),
(7803, 1290180467, 3, '71.235.209.187'),
(7804, 1290180467, 3, '119.118.72.161'),
(7805, 1290180467, 3, '187.72.191.162'),
(7806, 1290180467, 3, '92.62.151.123'),
(7807, 1290180467, 3, '92.98.98.139'),
(7808, 1290180467, 3, '120.28.231.6'),
(7809, 1290180467, 3, '77.29.125.234'),
(7810, 1290180467, 3, '222.218.51.81'),
(7811, 1290180467, 3, '62.245.142.18'),
(7812, 1290180467, 3, '111.178.43.47'),
(7813, 1290180467, 3, '187.49.137.35'),
(7814, 1290180467, 3, '86.28.177.168'),
(7815, 1290180467, 3, '111.240.141.90'),
(7816, 1290180467, 3, '111.252.197.236'),
(7817, 1290180467, 3, '174.46.183.85'),
(7818, 1290180467, 3, '114.39.109.229'),
(7819, 1290180467, 3, '222.78.226.69'),
(7820, 1290180467, 3, '118.97.224.2'),
(7821, 1290180467, 3, '203.168.193.2'),
(7822, 1290180467, 3, '61.152.91.223'),
(7823, 1290180467, 3, '173.203.58.76'),
(7824, 1290180467, 3, '123.11.157.155'),
(7825, 1290180467, 3, '60.27.158.98'),
(7826, 1290180467, 3, '87.106.249.81'),
(7827, 1290180467, 3, '221.79.44.54'),
(7828, 1290180467, 3, '122.168.31.150'),
(7829, 1290180467, 3, '195.235.161.28'),
(7830, 1290180467, 3, '180.190.156.207'),
(7831, 1290180467, 3, '62.212.144.131'),
(7832, 1290180467, 3, '59.180.173.179'),
(7833, 1290180467, 3, '110.137.105.37'),
(7834, 1290180467, 3, '120.28.188.10'),
(7835, 1290180467, 3, '121.1.11.87'),
(7836, 1290180467, 3, '94.75.30.50'),
(7837, 1290180467, 3, '94.143.43.85'),
(7838, 1290180467, 3, '203.223.95.88'),
(7839, 1290180467, 3, '87.160.152.99'),
(7840, 1290180467, 3, '184.72.52.168'),
(7841, 1290180467, 3, '190.213.220.162'),
(7842, 1290180467, 3, '187.58.118.137'),
(7843, 1290180467, 3, '91.121.139.227'),
(7844, 1290180467, 3, '125.166.253.143'),
(7845, 1290180467, 3, '18.111.98.203'),
(7846, 1290180467, 3, '113.26.6.125'),
(7847, 1290180467, 3, '66.213.92.130'),
(7848, 1290180467, 3, '183.83.245.138'),
(7849, 1290180467, 3, '120.28.211.129'),
(7850, 1290180467, 3, '124.106.222.19'),
(7851, 1290180467, 3, '222.135.63.73'),
(7852, 1290180467, 3, '200.43.192.163'),
(7853, 1290180467, 3, '125.82.0.19'),
(7854, 1290180467, 3, '218.84.142.158'),
(7855, 1290180467, 3, '193.34.144.91'),
(7856, 1290180467, 3, '188.51.5.67'),
(7857, 1290180467, 3, '110.55.172.217'),
(7858, 1290180467, 3, '95.27.87.30'),
(7859, 1290180467, 3, '122.3.182.58'),
(7860, 1290180467, 3, '98.142.218.28'),
(7861, 1290180467, 3, '98.142.218.131'),
(7862, 1290180467, 3, '173.245.64.76'),
(7863, 1290180467, 3, '115.132.68.99'),
(7864, 1290180467, 3, '190.4.32.26'),
(7865, 1290180467, 3, '120.28.207.157'),
(7866, 1290180467, 3, '182.52.100.232'),
(7867, 1290180467, 3, '117.205.6.129'),
(7868, 1290180467, 3, '173.208.125.136'),
(7869, 1290180467, 3, '41.210.12.172'),
(7870, 1290180467, 3, '216.66.45.234'),
(7871, 1290180467, 3, '173.208.125.135'),
(7872, 1290180467, 3, '188.2.200.121'),
(7873, 1290180467, 3, '95.79.205.41'),
(7874, 1290180467, 3, '95.25.40.143'),
(7875, 1290180467, 3, '92.25.22.18'),
(7876, 1290180467, 3, '110.54.163.245'),
(7877, 1290180467, 3, '95.27.213.88'),
(7878, 1290180467, 3, '120.28.207.132'),
(7879, 1290180467, 3, '190.87.240.125'),
(7880, 1290180467, 3, '209.105.140.144'),
(7881, 1290180467, 3, '202.133.58.13'),
(7882, 1290180467, 3, '209.236.115.192'),
(7883, 1290180467, 3, '114.143.55.124'),
(7884, 1290180467, 3, '93.80.249.79'),
(7885, 1290180467, 3, '112.203.93.199'),
(7886, 1290180467, 3, '99.191.155.253'),
(7887, 1290180467, 3, '122.162.151.146'),
(7888, 1290180467, 3, '188.28.38.202'),
(7889, 1290180467, 3, '122.144.115.240'),
(7890, 1290180467, 3, '112.198.193.253'),
(7891, 1290180467, 3, '71.205.120.30'),
(7892, 1290180467, 3, '58.27.156.163'),
(7893, 1290180467, 3, '109.169.57.139'),
(7894, 1290180467, 3, '203.129.195.194'),
(7895, 1290180467, 3, '183.89.139.243'),
(7896, 1290180467, 3, '122.3.182.60'),
(7897, 1290180467, 3, '218.86.51.167'),
(7898, 1290180467, 3, '196.210.204.55'),
(7899, 1290180467, 3, '78.142.1.191'),
(7900, 1290180467, 3, '112.198.163.190'),
(7901, 1290180467, 3, '112.198.248.240'),
(7902, 1290180467, 3, '112.198.204.221'),
(7903, 1290180467, 3, '117.206.128.207'),
(7904, 1290180467, 3, '92.237.192.87'),
(7905, 1290180467, 3, '113.167.145.30'),
(7906, 1290180467, 3, '212.124.116.241'),
(7907, 1290180467, 3, '90.221.151.113'),
(7908, 1290180467, 3, '123.27.106.79'),
(7909, 1290180467, 3, '69.114.227.40'),
(7910, 1290180467, 3, '95.26.207.177'),
(7911, 1290180467, 3, '202.69.102.146'),
(7912, 1290180467, 3, '1.23.65.134'),
(7913, 1290180467, 3, '122.163.18.204'),
(7914, 1290180467, 3, '207.67.149.180'),
(7915, 1290180467, 3, '94.253.254.80'),
(7916, 1290180467, 3, '95.27.236.220'),
(7917, 1290180467, 3, '202.84.120.38'),
(7918, 1290180467, 3, '122.163.54.146'),
(7919, 1290180467, 3, '202.78.92.106'),
(7920, 1290180467, 3, '175.137.65.153'),
(7921, 1290180467, 3, '69.31.101.161'),
(7922, 1290180467, 3, '125.166.172.100'),
(7923, 1290180467, 3, '122.163.130.38'),
(7924, 1290180467, 3, '120.28.242.220'),
(7925, 1290180467, 3, '95.79.207.211'),
(7926, 1290180467, 3, '93.80.225.18'),
(7927, 1290180467, 3, '210.83.222.27'),
(7928, 1290180467, 3, '95.26.238.43'),
(7929, 1290180467, 3, '178.22.192.193'),
(7930, 1290180467, 3, '173.183.77.205'),
(7931, 1290180467, 3, '124.6.181.90'),
(7932, 1290180467, 3, '98.193.149.153'),
(7933, 1290180467, 3, '173.17.14.172'),
(7934, 1290180467, 3, '62.122.208.186'),
(7935, 1290180467, 3, '95.27.146.217'),
(7936, 1290180467, 3, '119.153.74.14'),
(7937, 1290180467, 3, '24.206.9.65'),
(7938, 1290180467, 3, '95.25.129.146'),
(7939, 1290180467, 3, '89.21.118.119'),
(7940, 1290180467, 3, '109.123.70.154'),
(7941, 1290180467, 3, '120.56.140.131'),
(7942, 1290180467, 3, '46.73.47.153'),
(7943, 1290180467, 3, '46.73.47.153'),
(7944, 1290180467, 3, '117.102.241.2'),
(7945, 1290180467, 3, '76.185.174.50'),
(7946, 1290180467, 3, '173.234.234.17'),
(7947, 1290180467, 3, '80.174.232.145'),
(7948, 1290180467, 3, '89.46.111.83'),
(7949, 1290180467, 3, '124.6.181.112'),
(7950, 1290180467, 3, '95.26.207.87'),
(7951, 1290180467, 3, '122.169.18.87'),
(7952, 1290180467, 3, '85.177.165.1'),
(7953, 1290180467, 3, '87.114.25.15'),
(7954, 1290180467, 3, '122.173.168.117'),
(7955, 1290180467, 3, '220.233.48.247'),
(7956, 1290180467, 3, '86.180.213.143'),
(7957, 1290180467, 3, '180.234.36.189'),
(7958, 1290180467, 3, '203.73.85.44'),
(7959, 1290180467, 3, '125.212.86.64'),
(7960, 1290180467, 3, '173.208.125.217'),
(7961, 1290180467, 3, '120.28.228.114'),
(7962, 1290180467, 3, '112.201.228.86'),
(7963, 1290180467, 3, '120.28.222.91'),
(7964, 1290180467, 3, '99.253.203.192'),
(7965, 1290180467, 3, '75.108.248.182'),
(7966, 1290180467, 3, '77.37.179.227'),
(7967, 1290180467, 3, '64.110.199.234'),
(7968, 1290180467, 3, '116.71.163.102'),
(7969, 1290180467, 3, '202.70.54.186'),
(7970, 1290180467, 3, '173.245.64.52'),
(7971, 1290180467, 3, '95.27.236.223'),
(7972, 1290180467, 3, '122.174.184.142'),
(7973, 1290180467, 3, '118.71.182.125'),
(7974, 1290180467, 3, '119.30.38.52'),
(7975, 1290180467, 3, '58.27.168.247'),
(7976, 1290180467, 3, '123.49.20.150'),
(7977, 1290180467, 3, '76.247.106.114'),
(7978, 1290180467, 3, '122.177.0.173'),
(7979, 1290180467, 3, '87.68.242.148'),
(7980, 1290180467, 3, '170.252.47.25'),
(7981, 1290180467, 3, '112.201.85.19'),
(7982, 1290180467, 3, '174.1.197.52'),
(7983, 1290180467, 3, '71.97.69.235'),
(7984, 1290180467, 3, '68.199.135.215'),
(7985, 1290180467, 3, '113.162.87.61'),
(7986, 1290180467, 3, '87.64.50.218'),
(7987, 1290180467, 3, '121.54.2.152'),
(7988, 1290180467, 3, '122.168.75.121'),
(7989, 1290180467, 3, '95.26.173.139'),
(7990, 1290180467, 3, '61.184.205.58'),
(7991, 1290180467, 3, '113.162.87.47'),
(7992, 1290180467, 3, '95.26.167.205'),
(7993, 1290180467, 3, '79.176.202.170'),
(7994, 1290180467, 3, '113.162.87.192'),
(7995, 1290180467, 3, '95.27.155.149'),
(7996, 1290180467, 3, '114.130.35.114'),
(7997, 1290180467, 3, '1.23.75.207'),
(7998, 1290180467, 3, '221.7.245.166'),
(7999, 1290180467, 3, '182.2.174.43'),
(8000, 1290180467, 3, '221.206.112.16'),
(8001, 1290180467, 3, '93.80.108.154'),
(8002, 1290180467, 3, '86.57.142.31'),
(8003, 1290180467, 3, '118.101.96.8'),
(8004, 1290180467, 3, '201.253.187.82'),
(8005, 1290180467, 3, '78.106.72.157'),
(8006, 1290180467, 3, '117.202.137.85'),
(8007, 1290180467, 3, '113.166.134.114'),
(8008, 1290180467, 3, '216.169.110.206'),
(8009, 1290180467, 3, '222.123.124.161'),
(8010, 1290180467, 3, '117.195.212.76'),
(8011, 1290180467, 3, '95.27.59.72'),
(8012, 1290180467, 3, '118.70.168.35'),
(8013, 1290180467, 3, '112.205.107.109'),
(8014, 1290180467, 3, '122.49.151.216'),
(8015, 1290180467, 3, '134.121.86.2'),
(8016, 1290180467, 3, '98.143.144.123'),
(8017, 1290180467, 3, '95.26.152.253'),
(8018, 1290180467, 3, '114.130.35.114'),
(8019, 1290180467, 3, '121.247.225.46'),
(8020, 1290180467, 3, '173.234.94.114'),
(8021, 1290180467, 3, '205.217.228.178'),
(8022, 1290180467, 3, '67.166.255.171'),
(8023, 1290180467, 3, '125.60.217.75'),
(8024, 1290180467, 3, '180.215.186.36'),
(8025, 1290180467, 3, '95.25.40.105'),
(8026, 1290180467, 3, '78.86.88.14'),
(8027, 1290180467, 3, '95.178.193.179'),
(8028, 1290180467, 3, '87.97.145.41'),
(8029, 1290180467, 3, '90.196.98.89'),
(8030, 1290180467, 3, '95.27.47.105'),
(8031, 1290180467, 3, '173.234.250.254'),
(8032, 1290180467, 3, '125.83.60.173'),
(8033, 1290180467, 3, '95.24.184.23'),
(8034, 1290180467, 3, '115.135.12.112'),
(8035, 1290180467, 3, '111.125.229.57'),
(8036, 1290180467, 3, '173.234.122.86'),
(8037, 1290180467, 3, '59.161.91.182'),
(8038, 1290180467, 3, '122.163.39.156'),
(8039, 1290180467, 3, '108.14.226.43'),
(8040, 1290180467, 3, '95.25.67.44'),
(8041, 1290180467, 3, '85.140.0.8'),
(8042, 1290180467, 3, '82.81.3.165'),
(8043, 1290180467, 3, '80.65.244.186'),
(8044, 1290180467, 3, '94.100.17.56'),
(8045, 1290180467, 3, '175.138.67.81'),
(8046, 1290180467, 3, '76.254.158.53'),
(8047, 1290180467, 3, '95.25.18.5'),
(8048, 1290180467, 3, '123.236.171.2'),
(8049, 1290180467, 3, '98.231.165.152'),
(8050, 1290180467, 3, '88.73.198.76'),
(8051, 1290180467, 3, '59.94.142.154'),
(8052, 1290180467, 3, '203.73.248.49'),
(8053, 1290180467, 3, '203.177.201.101'),
(8054, 1290180467, 3, '96.9.148.216'),
(8055, 1290180467, 3, '123.125.156.207'),
(8056, 1290180467, 3, '209.107.217.194'),
(8057, 1290180467, 3, '180.190.147.5'),
(8058, 1290180467, 3, '98.193.1.133'),
(8059, 1290180467, 3, '59.96.25.124'),
(8060, 1290180467, 3, '180.190.147.5'),
(8061, 1290180467, 3, '97.107.142.93'),
(8062, 1290180467, 3, '117.196.226.238'),
(8063, 1290180467, 3, '76.210.42.137'),
(8064, 1290180467, 3, '122.168.240.12'),
(8065, 1290180467, 3, '69.22.184.72'),
(8066, 1290180467, 3, '113.169.158.69'),
(8067, 1290180467, 3, '202.70.51.23'),
(8068, 1290180467, 3, '166.137.137.158'),
(8069, 1290180467, 3, '68.25.42.135'),
(8070, 1290180467, 3, '110.138.129.183'),
(8071, 1290180467, 3, '58.71.83.249'),
(8072, 1290180467, 3, '112.203.234.16'),
(8073, 1290180467, 3, '173.208.125.223'),
(8074, 1290180467, 3, '24.1.1.16'),
(8075, 1290180467, 3, '80.143.81.4'),
(8076, 1290180467, 3, '122.168.52.9'),
(8077, 1290180467, 3, '116.71.61.46'),
(8078, 1290180467, 3, '96.44.154.7'),
(8079, 1290180467, 3, '173.208.25.138'),
(8080, 1290180467, 3, '59.180.139.151'),
(8081, 1290180467, 3, '61.29.25.21'),
(8082, 1290180467, 3, '119.158.88.139'),
(8083, 1290180467, 3, '117.205.5.76'),
(8084, 1290180467, 3, '109.92.85.64'),
(8085, 1290180467, 3, '92.1.158.235'),
(8086, 1290180467, 3, '188.121.193.214'),
(8087, 1290180467, 3, '188.121.193.214'),
(8088, 1290180467, 3, '123.27.97.231'),
(8089, 1290180467, 3, '84.240.205.113'),
(8090, 1290180467, 3, '122.161.33.164'),
(8091, 1290180467, 3, '68.71.52.41'),
(8092, 1290180467, 3, '118.101.166.179'),
(8093, 1290180467, 3, '112.198.194.181'),
(8094, 1290180467, 3, '122.172.157.218'),
(8095, 1290180467, 3, '112.203.235.127'),
(8096, 1290180467, 3, '70.168.117.164'),
(8097, 1290180467, 3, '108.25.42.141'),
(8098, 1290180467, 3, '112.203.101.128'),
(8099, 1290180467, 3, '58.27.205.189'),
(8100, 1290180467, 3, '82.230.56.56'),
(8101, 1290180467, 3, '97.102.133.219'),
(8102, 1290180467, 3, '123.49.24.27'),
(8103, 1290180467, 3, '198.248.45.230'),
(8104, 1290180467, 3, '218.186.8.243'),
(8105, 1290180467, 3, '117.193.111.80'),
(8106, 1290180467, 3, '173.245.64.46'),
(8107, 1290180467, 3, '91.51.34.22'),
(8108, 1290180467, 3, '83.24.48.110'),
(8109, 1290180467, 3, '68.197.42.77'),
(8110, 1290180467, 3, '87.154.208.203'),
(8111, 1290180467, 3, '64.255.180.219'),
(8112, 1290180467, 3, '96.239.137.140'),
(8113, 1290180467, 3, '122.161.61.124'),
(8114, 1290180467, 3, '59.180.155.60'),
(8115, 1290180467, 3, '112.201.25.186'),
(8116, 1290180467, 3, '175.42.82.172'),
(8117, 1290180467, 3, '82.124.51.116'),
(8118, 1290180467, 3, '94.12.215.74'),
(8119, 1290180467, 3, '180.215.42.190'),
(8120, 1290180467, 3, '120.28.227.219'),
(8121, 1290180467, 3, '122.179.42.64'),
(8122, 1290180467, 3, '120.28.196.90'),
(8123, 1290180807, 4, 'viagra'),
(8124, 1290180807, 4, 'degree'),
(8125, 1290180807, 4, 'gambling'),
(8126, 1290180807, 4, 'gamble'),
(8127, 1290180807, 4, 'credit'),
(8128, 1290180807, 4, 'horoscope'),
(8129, 1290180807, 4, 'deal'),
(8130, 1290180807, 4, 'debt'),
(8131, 1290180807, 4, 'loan'),
(8132, 1290180807, 4, 'discount'),
(8133, 1290180807, 4, 'money'),
(8134, 1290180807, 4, 'promo'),
(8135, 1290180807, 4, 'adult'),
(8136, 1290180807, 4, 'celebrex'),
(8137, 1290180807, 4, 'ambian'),
(8138, 1290180807, 4, 'ambieen'),
(8139, 1290180807, 4, 'ambiian'),
(8140, 1290180807, 4, 'cial11s'),
(8141, 1290180807, 4, 'cialis'),
(8142, 1290180807, 4, 'cheap'),
(8143, 1290180807, 4, 'drug'),
(8144, 1290180807, 4, 'generic'),
(8145, 1290180807, 4, 'hydrocondone'),
(8146, 1290180807, 4, 'inexpensive'),
(8147, 1290180807, 4, 'levitra'),
(8148, 1290180807, 4, 'porn'),
(8149, 1290180807, 4, 'm3ds'),
(8150, 1290180807, 4, 'medication'),
(8151, 1290180807, 4, 'medicine'),
(8152, 1290180807, 4, 'meds'),
(8153, 1290180807, 4, 'nacrotics'),
(8154, 1290180807, 4, 'order'),
(8155, 1290180807, 4, 'paracodin'),
(8156, 1290180807, 4, 'perscription'),
(8157, 1290180807, 4, 'teen'),
(8158, 1290180807, 4, 'naked'),
(8159, 1290180807, 4, 'nude'),
(8160, 1290180807, 4, 'ambien'),
(8163, 1290180807, 4, 'pharmracy'),
(8164, 1290180807, 4, 'phamracy'),
(8165, 1290180807, 4, 'phamraceutical'),
(8166, 1290180807, 4, 'pharma'),
(8167, 1290180807, 4, 'pharmaceuticals'),
(8168, 1290180807, 4, 'pharmacy'),
(8169, 1290180807, 4, 'phentermine'),
(8170, 1290180807, 4, 'pills'),
(8171, 1290180807, 4, 'perscription'),
(8172, 1290180807, 4, 'prozac'),
(8173, 1290180807, 4, 'regalis'),
(8174, 1290180807, 4, 'ultram'),
(8175, 1290180807, 4, 'vallium'),
(8176, 1290180807, 4, 'v1agra'),
(8177, 1290180807, 4, 'vlagra'),
(8178, 1290180807, 4, 'codin'),
(8179, 1290180807, 4, 'xanax'),
(8180, 1290180807, 4, 'xanacs'),
(8181, 1290180807, 4, 'xaanax'),
(8182, 1290180807, 4, 'x.anax');
