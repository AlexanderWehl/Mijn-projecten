import React, { useState, useEffect } from "react";
import { base44 } from "@/api/base44Client";
import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { Button } from "@/components/ui/button";
import { Plus, Calendar, Music } from "lucide-react";
import { AnimatePresence } from "framer-motion";
import { useNavigate } from "react-router-dom";
import { createPageUrl } from "@/utils";
import EventCard from "../components/events/EventCard";
import EventForm from "../components/events/EventForm";
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
} from "@/components/ui/alert-dialog";

export default function Dashboard() {
  const navigate = useNavigate();
  const queryClient = useQueryClient();
  const [editingEvent, setEditingEvent] = useState(null);
  const [deletingEvent, setDeletingEvent] = useState(null);
  const [user, setUser] = useState(null);

  useEffect(() => {
    base44.auth.me().then(setUser).catch(() => {
      base44.auth.redirectToLogin();
    });
  }, []);

  const { data: events, isLoading } = useQuery({
    queryKey: ['events'],
    queryFn: async () => {
      const user = await base44.auth.me();
      return base44.entities.Event.filter({ created_by: user.email }, "-datum");
    },
    initialData: [],
  });

  const updateEventMutation = useMutation({
    mutationFn: ({ id, data }) => base44.entities.Event.update(id, data),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['events'] });
      setEditingEvent(null);
    },
  });

  const deleteEventMutation = useMutation({
    mutationFn: (id) => base44.entities.Event.delete(id),
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ['events'] });
      setDeletingEvent(null);
    },
  });

  const handleEdit = (event) => {
    setEditingEvent(event);
  };

  const handleDelete = (event) => {
    setDeletingEvent(event);
  };

  const confirmDelete = () => {
    if (deletingEvent) {
      deleteEventMutation.mutate(deletingEvent.id);
    }
  };

  const handleUpdate = (data) => {
    if (editingEvent) {
      updateEventMutation.mutate({ id: editingEvent.id, data });
    }
  };

  const upcomingEvents = events.filter(e => new Date(e.datum) >= new Date());
  const pastEvents = events.filter(e => new Date(e.datum) < new Date());

  return (
    <div className="space-y-8">
      {editingEvent && (
        <div className="mb-8">
          <EventForm
            event={editingEvent}
            onSubmit={handleUpdate}
            onCancel={() => setEditingEvent(null)}
            isProcessing={updateEventMutation.isPending}
          />
        </div>
      )}

      {!editingEvent && (
        <>
          <div className="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
              <h1 className="text-4xl font-bold text-white mb-2">Mijn Optredens</h1>
              <p className="text-purple-100">Beheer al je geplande events op één plek</p>
            </div>
            <Button
              onClick={() => navigate(createPageUrl("NieuwOptreden"))}
              className="bg-white text-purple-700 hover:bg-purple-50 shadow-lg"
            >
              <Plus className="w-5 h-5 mr-2" />
              Nieuw Optreden
            </Button>
          </div>

          {isLoading ? (
            <div className="text-center py-12">
              <div className="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-white"></div>
            </div>
          ) : events.length === 0 ? (
            <div className="bg-white/95 backdrop-blur-sm rounded-xl shadow-xl p-12 text-center border-2 border-purple-200">
              <Calendar className="w-16 h-16 text-purple-400 mx-auto mb-4" />
              <h3 className="text-xl font-semibold text-gray-900 mb-2">
                Nog geen optredens gepland
              </h3>
              <p className="text-gray-600 mb-6">
                Begin met het toevoegen van je eerste optreden
              </p>
              <Button
                onClick={() => navigate(createPageUrl("NieuwOptreden"))}
                className="bg-gradient-to-r from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white"
              >
                <Plus className="w-5 h-5 mr-2" />
                Eerste Optreden Toevoegen
              </Button>
            </div>
          ) : (
            <div className="space-y-8">
              {upcomingEvents.length > 0 && (
                <div>
                  <div className="flex items-center gap-2 mb-4">
                    <Music className="w-6 h-6 text-white" />
                    <h2 className="text-2xl font-bold text-white">
                      Aankomende Optredens ({upcomingEvents.length})
                    </h2>
                  </div>
                  <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <AnimatePresence>
                      {upcomingEvents.map((event) => (
                        <EventCard
                          key={event.id}
                          event={event}
                          onEdit={handleEdit}
                          onDelete={handleDelete}
                        />
                      ))}
                    </AnimatePresence>
                  </div>
                </div>
              )}

              {pastEvents.length > 0 && (
                <div>
                  <div className="flex items-center gap-2 mb-4">
                    <Calendar className="w-6 h-6 text-white" />
                    <h2 className="text-2xl font-bold text-white">
                      Afgelopen Optredens ({pastEvents.length})
                    </h2>
                  </div>
                  <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <AnimatePresence>
                      {pastEvents.map((event) => (
                        <EventCard
                          key={event.id}
                          event={event}
                          onEdit={handleEdit}
                          onDelete={handleDelete}
                        />
                      ))}
                    </AnimatePresence>
                  </div>
                </div>
              )}
            </div>
          )}
        </>
      )}

      <AlertDialog open={!!deletingEvent} onOpenChange={() => setDeletingEvent(null)}>
        <AlertDialogContent>
          <AlertDialogHeader>
            <AlertDialogTitle>Weet je het zeker?</AlertDialogTitle>
            <AlertDialogDescription>
              Wil je "{deletingEvent?.titel}" verwijderen? Deze actie kan niet ongedaan gemaakt worden.
            </AlertDialogDescription>
          </AlertDialogHeader>
          <AlertDialogFooter>
            <AlertDialogCancel>Annuleren</AlertDialogCancel>
            <AlertDialogAction
              onClick={confirmDelete}
              className="bg-red-600 hover:bg-red-700"
            >
              Verwijderen
            </AlertDialogAction>
          </AlertDialogFooter>
        </AlertDialogContent>
      </AlertDialog>
    </div>
  );
}