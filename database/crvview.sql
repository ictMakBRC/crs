

DROP VIEW IF EXISTS `TAT_Per_Entry`;
CREATE ALGORITHM=UNDEFINED DEFINER=`crs`@`localhost` SQL SECURITY DEFINER VIEW `TAT_Per_Entry` AS SELECT `wagonjwas`.`pat_no` AS `PatientNo`, 
`wagonjwas`.`lab_no` AS `LabNo`, 
date_format(`wagonjwas`.`created_at`,'%Y-%m-%d') AS `DateCreated`,
date_format(`wagonjwas`.`created_at`,'%Y-%m') AS `MonthCreated`, 
date_format(`wagonjwas`.`created_at`,'Y') AS `YearCreated`, 
QUARTER(`wagonjwas`.`created_at`) AS `Myquarter`, 
timestampdiff(MINUTE,`wagonjwas`.`created_at`,`wagonjwas`.`accessioned_at`) AS `EntryToReceipt`, 
timestampdiff(MINUTE,`wagonjwas`.`accessioned_at`,`wagonjwas`.`entered_at`) AS `ReceiptToVerification`, 
timestampdiff(MINUTE,`wagonjwas`.`entered_at`,`wagonjwas`.`result_added_at`) AS `VerificationToResult`, 
timestampdiff(MINUTE,`wagonjwas`.`accessioned_at`,`wagonjwas`.`result_added_at`) AS `ReceiptToResult`, 
timestampdiff(MINUTE,`wagonjwas`.`created_at`,`wagonjwas`.`result_added_at`) AS `EntryToResult` FROM `wagonjwas`;