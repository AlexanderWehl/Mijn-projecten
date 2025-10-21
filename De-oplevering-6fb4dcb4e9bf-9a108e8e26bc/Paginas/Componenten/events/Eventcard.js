import React from "react";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Button } from "@/components/ui/button";
import { Calendar, Clock, MapPin, Edit, Trash2 } from "lucide-react";
import { format } from "date-fns";
import { nl } from "date-fns/locale";
import { motion } from "framer-motion";

export default function EventCard({ event, onEdit, onDelete }) {
  const eventDatum = new Date(event.datum);
  const isUpcoming = eventDatum >= new Date();

  return (
    <motion.div
      initial={{ opacity: 0, y: 20 }}
      animate={{ opacity: 1, y: 0 }}
      exit={{ opacity: 0, y: -20 }}
    >
      <Card className="bg-white/95 backdrop-blur-sm hover:shadow-xl transition-all duration-300 border-2 border-purple-100 hover:border-purple-300">
        <CardHeader className="pb-3">
          <div className="flex justify-between items-start">
            <div className="flex-1">
              <CardTitle className="text-xl font-bold text-gray-900 mb-2">
                {event.titel}
              </CardTitle>
              <Badge 
                variant="secondary" 
                className={isUpcoming ? "bg-green-100 text-green-700" : "bg-gray-100 text-gray-700"}
              >
                {isUpcoming ? "Aankomend" : "Afgelopen"}
              </Badge>
            </div>
          </div>
        </CardHeader>
        <CardContent className="space-y-3">
          {event.omschrijving && (
            <p className="text-gray-600 text-sm">{event.omschrijving}</p>
          )}
          
          <div className="space-y-2 pt-2">
            <div className="flex items-center gap-2 text-gray-700">
              <Calendar className="w-4 h-4 text-purple-500" />
              <span className="text-sm font-medium">
                {format(eventDatum, "EEEE d MMMM yyyy", { locale: nl })}
              </span>
            </div>
            
            <div className="flex items-center gap-2 text-gray-700">
              <Clock className="w-4 h-4 text-purple-500" />
              <span className="text-sm font-medium">{event.tijd}</span>
            </div>
            
            {event.locatie && (
              <div className="flex items-center gap-2 text-gray-700">
                <MapPin className="w-4 h-4 text-purple-500" />
                <span className="text-sm font-medium">{event.locatie}</span>
              </div>
            )}
          </div>

          <div className="flex gap-2 pt-4 border-t border-purple-100">
            <Button
              variant="outline"
              size="sm"
              onClick={() => onEdit(event)}
              className="flex-1 border-purple-200 hover:bg-purple-50 hover:text-purple-700"
            >
              <Edit className="w-4 h-4 mr-2" />
              Bewerken
            </Button>
            <Button
              variant="outline"
              size="sm"
              onClick={() => onDelete(event)}
              className="flex-1 border-red-200 hover:bg-red-50 hover:text-red-700"
            >
              <Trash2 className="w-4 h-4 mr-2" />
              Verwijderen
            </Button>
          </div>
        </CardContent>
      </Card>
    </motion.div>
  );
}