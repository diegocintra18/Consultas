//Calculando quantas consultas podem ser realizadas em um dia
        $durationAndBreak = $timeObj->duration + $timeObj->beforeBreak + $timeObj->afterBreak;
        $timeObj->break = $timeObj->beforeBreak + $timeObj->afterBreak;
        $disponibilityMorning = strtotime($timeObj->lunchStart) - strtotime($timeObj->dayStart);
        $disponibilityAfternoon = strtotime($timeObj->dayEnd) - strtotime($timeObj->lucnhEnd);
        $timeMorning = ($disponibilityMorning/60) / $durationAndBreak;
        $timeAfternoon = ($disponibilityAfternoon/60) / $durationAndBreak;

        function convertHoras($horasInteiras) {

            // Define o formato de saida
            $formato = '%02d:%02d';
            // Converte para minutos
            $minutos = $horasInteiras;

            // Converte para o formato hora
            $horas = floor($minutos / 60);
            $minutos = ($minutos % 60);

            // Retorna o valor
            return sprintf($formato, $horas, $minutos);
        }

        function scheduleTimeMorning(stdClass $timeObj, $time, $id){
            // Este for cria todas as faixas de horário seguindo as regras cadastradas
            for($i = 0; $i < $time; $i++){
                
                if ($i == 0){
                    $timeObj->scheduleEnd = strtotime($timeObj->dayStart) + strtotime(convertHoras($timeObj->duration));
                    $timeObj->nextSchedule = $timeObj->scheduleEnd + strtotime(convertHoras($timeObj->break));
                    $timeObj->nextScheduleEnd = $timeObj->nextSchedule + strtotime(convertHoras($timeObj->duration));
                    
                    $available[0]['available_start'] = $timeObj->dayStart;
                    $available[0]['available_end'] = date('H:i',$timeObj->scheduleEnd);
                    $available[$i+1]['available_start'] = date('H:i',$timeObj->nextSchedule);
                    $available[$i+1]['available_end'] = date('H:i',$timeObj->nextScheduleEnd);
                } else {
                    $timeObj->nextSchedule = $timeObj->nextScheduleEnd + strtotime(convertHoras($timeObj->break));
                    $timeObj->nextScheduleEnd = $timeObj->nextSchedule + strtotime(convertHoras($timeObj->duration));

                    $a = date('H:i',$timeObj->nextScheduleEnd);
                    $b = date('H:i',strtotime($timeObj->lunchStart));

                    if ( $a < $b ) {

                        $available[$i+1]['available_start'] = date('H:i',$timeObj->nextSchedule);
                        $available[$i+1]['available_end'] = date('H:i',$timeObj->nextScheduleEnd);
                    }
                    
                }
            }
            
            foreach($available as $a){
                Available::create([
                    'available_start' => $a['available_start'],
                    'available_end' => $a['available_end'],
                    'schedule_settings_id' => $id
                ]);
            }
            
        }

        function scheduleTimeAfternoon(stdClass $timeObj, $time, $id){
            // Este for cria todas as faixas de horário seguindo as regras cadastradas
            for($i = 0; $i < $time; $i++){
                
                if ($i == 0){
                    $timeObj->scheduleEnd = strtotime($timeObj->lucnhEnd) + strtotime(convertHoras($timeObj->duration));
                    $timeObj->nextSchedule = $timeObj->scheduleEnd + strtotime(convertHoras($timeObj->break));
                    $timeObj->nextScheduleEnd = $timeObj->nextSchedule + strtotime(convertHoras($timeObj->duration));
                    
                    $available[0]['available_start'] = $timeObj->lucnhEnd;
                    $available[0]['available_end'] = date('H:i',$timeObj->scheduleEnd);
                    $available[$i+1]['available_start'] = date('H:i',$timeObj->nextSchedule);
                    $available[$i+1]['available_end'] = date('H:i',$timeObj->nextScheduleEnd);

                } else {
                    $timeObj->nextSchedule = $timeObj->nextScheduleEnd + strtotime(convertHoras($timeObj->break));
                    $timeObj->nextScheduleEnd = $timeObj->nextSchedule + strtotime(convertHoras($timeObj->duration));

                    $a = date('H:i',$timeObj->nextScheduleEnd);
                    $b = date('H:i',strtotime($timeObj->dayEnd));

                    if ( $a < $b ) {
                        $available[$i+1]['available_start'] = date('H:i',$timeObj->nextSchedule);
                        $available[$i+1]['available_end'] = date('H:i',$timeObj->nextScheduleEnd);
                    }
                    
                }
            }
            
            foreach($available as $a){
                Available::create([
                    'available_start' => $a['available_start'],
                    'available_end' => $a['available_end'],
                    'schedule_settings_id' => $id
                ]);
            }
        }